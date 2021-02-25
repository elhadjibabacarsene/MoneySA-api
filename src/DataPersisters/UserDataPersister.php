<?php


namespace App\DataPersisters;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\DataPersister\ResumableDataPersisterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use function Symfony\Component\Translation\t;

class UserDataPersister implements ContextAwareDataPersisterInterface
{

    private $em;
    private $encoder;

    public function __construct(EntityManagerInterface $entityManager,
                                UserPasswordEncoderInterface $encoder)
    {
        $this->em = $entityManager;
        $this->encoder = $encoder;
    }

    public function supports($data, array $context = []): bool
    {
        // TODO: Implement supports() method.
        return $data instanceof User;
    }

    public function persist($data, array $context = []): object
    {
        // TODO: Implement persist() method.
        if($context['collection_operation_name'] ?? null  === 'post' )
        {
            $data->setIsActive(true)
                ->setIsFirstConnexion(true)
                ->setIsDeleted(false)
                ->setPassword($this->encoder->encodePassword($data, 'password'));
        }
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
        $data->setIsDeleted(true);
        $this->em->persist($data);
        $this->em->flush();
    }
}