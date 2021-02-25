<?php


namespace App\DataPersisters;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Transaction;
use App\services\CodeTransaction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TransactionDataPersister implements ContextAwareDataPersisterInterface
{
    private $em;
    private $codeTransaction;

    public function __construct(EntityManagerInterface $entityManager, CodeTransaction $codeTransaction)
    {
       $this->em = $entityManager;
       $this->codeTransaction = $codeTransaction;
    }

    public function supports($data, array $context = []): bool
    {
        // TODO: Implement supports() method.
        return $data instanceof Transaction;
    }

    public function persist($data, array $context = [])
    {
        // TODO: Implement persist() method.
        if($context['collection_operation_name'] ?? null  === 'post')
        {
            //TODO::On fait le dépôt
            //Si le dépôt est possible
            if($data->getMontant() <= 5000){
                return new JsonResponse('Le solde de votre compte est insuffissant !', Response::HTTP_BAD_REQUEST);
            }

        }
    }

    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }
}