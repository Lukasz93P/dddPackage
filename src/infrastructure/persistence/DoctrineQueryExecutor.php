<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\infrastructure\persistence;


use Doctrine\ORM\EntityManagerInterface;
use Lukasz93P\dddPackage\application\query\exceptions\QueryResultNotFoundException;
use Lukasz93P\dddPackage\application\query\PaginatedQueryResult;
use Lukasz93P\dddPackage\application\query\Query;
use Lukasz93P\dddPackage\application\query\QueryExecutor;

class DoctrineQueryExecutor implements QueryExecutor
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getResult(Query $query): array
    {
        $sqlQuery = $this->entityManager->getConnection()->prepare($query->getStatement());
        $sqlQuery->execute($query->getValuesToBind());
        $resultData = $sqlQuery->fetchAll();
        if (empty($resultData)) {
            throw QueryResultNotFoundException::create();
        }

        return $query->expectsMultipleRows() ? $resultData : $resultData[0];
    }

    public function getPaginatedResult(Query $query): PaginatedQueryResult
    {
        return PaginatedQueryResult::fromDataAndRowsCount($this->getResult($query), $this->getLastQueryRowsCount());
    }

    private function getLastQueryRowsCount(): int
    {
        $sqlQuery = $this->entityManager->getConnection()->prepare('SELECT FOUND_ROWS() AS count');
        $sqlQuery->execute();

        return (int)$sqlQuery->fetch()['count'];
    }

}