<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\domain\persistence;


use RuntimeException;

interface TransactionManager
{
    /**
     * @param callable $transactionalFunction
     * @return void
     * @throws RuntimeException
     */
    public function transactional(callable $transactionalFunction): void;
}