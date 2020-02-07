<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\application\query;


use Lukasz93P\dddPackage\application\query\exceptions\QueryResultNotFoundException;

interface QueryExecutor
{
    /**
     * @param Query $query
     * @return array
     * @throws QueryResultNotFoundException
     */
    public function getResult(Query $query): array;

    /**
     * @param Query $query
     * @return PaginatedQueryResult
     * @throws QueryResultNotFoundException
     */
    public function getPaginatedResult(Query $query): PaginatedQueryResult;
}