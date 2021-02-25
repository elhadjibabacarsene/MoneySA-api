<?php


namespace App\DataPersisters;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\DataPersister\ResumableDataPersisterInterface;
use App\Entity\Compte;
use App\services\NumCompte;
use Doctrine\ORM\EntityManagerInterface;

class CompteDataPersister implements ContextAwareDataPersisterInterface, ResumableDataPersisterInterface
{
    private $em;
    private $numCompte;

    public function __construct(EntityManagerInterface $entityManager,
                                NumCompte $numCompte)
    {
        $this->em = $entityManager;
        $this->numCompte = $numCompte;
    }

    public function supports($data, array $context = []): bool
    {
        // TODO: Implement supports() method.
        return $data instanceof Compte;
    }

    public function persist($data, array $context = [])
    {
        // TODO: Implement persist() method.
        if($context['collection_operation_name'] ?? null  === 'post' )
        {
            $data->setSolde(700000)
                ->setNumero($this->numCompte->generate())
                ->setCreatedAt(new \DateTime('now'))
                ->setIsActive(true);
        }
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }

    public function resumable(array $context = []): bool
    {
        // TODO: Implement resumable() method.
        return true;
    }
}
