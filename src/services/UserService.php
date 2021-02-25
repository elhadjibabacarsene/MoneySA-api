<?php


namespace App\services;


use App\Entity\User;
use App\Repository\AgenceRepository;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UserService
{

    private $uploadImage;
    private $denormalizer;
    private $em;
    private $roleRepository;
    private $agenceRepository;
    private $commonService;
    private $userRepository;
    private $extractData;
    private $encoder;

    public function __construct(UploadImage $uploadImage,
                                DenormalizerInterface $denormalizer,
                                EntityManagerInterface $entityManager,
                                RoleRepository $roleRepository,
                                AgenceRepository $agenceRepository,
                                CommonsService $commonService,
                                UserRepository $userRepository,
                                ExtractData $extractData,
                                UserPasswordEncoderInterface $encoder)
    {
        $this->uploadImage = $uploadImage;
        $this->denormalizer = $denormalizer;
        $this->em = $entityManager;
        $this->roleRepository = $roleRepository;
        $this->agenceRepository = $agenceRepository;
        $this->commonService = $commonService;
        $this->userRepository = $userRepository;
        $this->extractData = $extractData;
        $this->encoder = $encoder;
    }

    /**
     * Permet d'ajouter un utilisateur
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function createUser(Request $request)
    {
        //On récupère le contenu de la requete
        $userData = $request->request->all();
        //On gère la photo
        $userData['photo'] = $this->uploadImage->addImage($request, 'photo');
        //On dénormalize
        $user = $this->denormalizer->denormalize($userData, User::class);
        //On ajoute le password
        $user->setPassword($this->encoder->encodePassword($user, 'password'));
        //On ajoute le profil
        if(isset($userData['idRole']) && !empty($userData['idRole'])){
            $role = $this->roleRepository->find((int)$userData['idRole']);
            if($role){
                unset($userData['idRole']);
                $user->setRole($role);
            }
        }
        //On ajoute l'agence
        if(isset($userData['idAgence']) && !empty($userData['idAgence']))
        {
            $agence = $this->agenceRepository->find((int)$userData['idAgence']);
            if($agence){
                unset($userData['idAgence']);
                $user->setAgence($agence);
            }
        }
        //On valide les données
        $this->commonService->controlErrorsData($user);
        //On envoi les données
        $this->em->persist($user);
        $this->em->flush();

        return new JsonResponse('L\'utlisateur a été ajouté !', Response::HTTP_OK);
    }

    /**
     * Permet de gérer la modification d'un utilisateur
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateUser(Request $request, int $id)
    {
        //On récupère l'utilisateur
        $user = $this->userRepository->find($id);
        //On extrait les données
        $dataUpdate = $this->extractData->extract($request);
        //Om met à jour les valeurs
        if($user && !$user->getIsDeleted()){
            foreach ( $dataUpdate as $name => $value) {
                //On crée la méthode en fonction de la clé
                $method = 'set'.ucfirst($name);
                //On vérifie si le méthode existe
                if(method_exists($user, $method))
                {
                    //On met à jour la donnée correspondante
                    $user->$method($value);
                }
            }
        }
        //On envoi les données
        $this->em->persist($user);
        $this->em->flush();

        return new JsonResponse('success', Response::HTTP_OK);
    }
}