<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\infrastructure\persistence;


use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\Persistence\ManagerRegistry;
use Lukasz93P\dddPackage\domain\persistence\exceptions\AggregateNotFound;
use Lukasz93P\dddPackage\domain\persistence\exceptions\AggregatePersistingFailed;
use Lukasz93P\DoctrineDomainIdTypes\domainId\AggregateId;

abstract class BaseDoctrineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->getEntityClassName());
    }

    /**
     * @param object $aggregateSnapshot
     * @throws AggregatePersistingFailed
     */
    protected function persistAggregateSnapshot($aggregateSnapshot): void
    {
        try {
            $this->getEntityManager()->persist($aggregateSnapshot);
        } catch (ORMInvalidArgumentException | ORMException $exception) {
            throw AggregatePersistingFailed::fromReason($exception);
        }
    }

    /**
     * @param AggregateId $id
     * @return object
     * @throws AggregateNotFound
     */
    protected function findAggregateSnapshotById(AggregateId $id)
    {
        $foundAggregateSnapshot = $this->find($id->toString());
        $this->throwAggregateNotFoundExceptionIfAggregateSnapshotWasNotFound($foundAggregateSnapshot);

        return $foundAggregateSnapshot;
    }

    /**
     * @param array $fields
     * @return object
     * @throws AggregateNotFound
     */
    protected function findAggregateSnapshotByFields(array $fields)
    {
        $foundAggregateSnapshot = $this->findOneBy($fields);
        $this->throwAggregateNotFoundExceptionIfAggregateSnapshotWasNotFound($foundAggregateSnapshot);

        return $foundAggregateSnapshot;
    }

    /**
     * @param object|null $foundAggregateSnapshot
     * @throws AggregateNotFound
     */
    protected function throwAggregateNotFoundExceptionIfAggregateSnapshotWasNotFound($foundAggregateSnapshot = null): void
    {
        if (!$foundAggregateSnapshot) {
            throw AggregateNotFound::create();
        }
    }

    abstract protected function getEntityClassName(): string;
}