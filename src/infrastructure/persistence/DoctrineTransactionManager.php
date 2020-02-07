<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\infrastructure\persistence;


use Doctrine\ORM\EntityManagerInterface;
use Lukasz93P\dddPackage\domain\persistence\TransactionManager;

class DoctrineTransactionManager implements TransactionManager
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transactional(callable $transactionalFunction): void
    {
        $this->entityManager->transactional($transactionalFunction);
    }

}