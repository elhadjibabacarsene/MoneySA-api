<?php


namespace App\services;


use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Agence;
use App\Entity\Compte;
use App\Entity\User;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class CompteService
{

    private $denormalizer;
    private $validator;
    private $commonService;
    private $em;
    private $numCompte;
    private $encoder;
    private $randomPassword;
    private $roleRepository;
    private $uploadImage;

    public function __construct(DenormalizerInterface $denormalizer,
                                ValidatorInterface $validator,
                                CommonsService $commonService,
                                EntityManagerInterface $entityManager,
                                NumCompte $numCompte, UserPasswordEncoderInterface $encoder,
                                RandomPassword $randomPassword, RoleRepository $roleRepository,
                                UploadImage $uploadImage)
    {
        $this->denormalizer = $denormalizer;
        $this->validator = $validator;
        $this->commonService = $commonService;
        $this->em = $entityManager;
        $this->numCompte = $numCompte;
        $this->encoder = $encoder;
        $this->randomPassword = $randomPassword;
        $this->roleRepository = $roleRepository;
        $this->uploadImage = $uploadImage;
    }

    /**
     * Permet de créer un compte de transaction, l'agence ainsi que son compte admin
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function createCompte(Request $request)
    {
        //On récupère le contenu de la requete
        $requestContent = $request->request->all();


        //TODO::On gère les données de l'agence
        $agenceData = array();
        $agenceData['libelle'] = $requestContent['libelleAgence'];
        $agenceData['telephone'] = $requestContent['telephoneAgence'];
        $agenceData['lattitude'] = (float)$requestContent['lattitude'];
        $agenceData['longitude'] = (float)$requestContent['longitude'];
        //On dénormalize
        $agence = $this->denormalizer->denormalize($agenceData, Agence::class);

        //On persist l'objet agence
        $this->em->persist($agence);
        //TODO::On gère les données de l'admin
        $adminData = array();
        $adminData['prenom'] = $requestContent['prenomAdmin'];
        $adminData['nom'] = $requestContent['nomAdmin'];
        $adminData['email'] = $requestContent['emailAdmin'];
        $adminData['telephone'] = $requestContent['telephoneAdmin'];
        //On gère l'image
        $adminData['photo'] = $this->uploadImage->addImage($request, 'photo');
        //On dénormalize
        $user = $this->denormalizer->denormalize($adminData, User::class);
        //On valide les données
        $this->commonService->controlErrorsData($user);
        //On associe l'admin à l'agence
        $user->setAgence($agence);
        $user->setRole($this->roleRepository->findOneBy(['libelle'=>'ADMIN']));
        $user->setPassword($this->encoder->encodePassword($user, 'password'));
        $this->em->persist($user);

        //TODO::On gère les données du compte
        $compte = new Compte();
        $compte->setAgence($agence)
            ->setNumero($this->numCompte->generate());
        //On persist
        $this->em->persist($compte);

        $this->em->flush();

        return new JsonResponse('Le compte a été créer avec succès', Response::HTTP_OK);
    }
}