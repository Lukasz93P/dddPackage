<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\domain\shared;


use Lukasz93P\dddPackage\application\exceptions\ApplicationLayerException;
use Lukasz93P\SymfonyHttpApi\filesStorage\FileToStore;

interface TransactionalFunction
{
    /**
     * @param callable $functionToExecuteInsideTransaction
     * @throws ApplicationLayerException
     */
    public function transactional(callable $functionToExecuteInsideTransaction): void;

    /**
     * @param FileToStore $fileToStore
     * @param string $destinationPath
     * @param callable $functionToExecuteInsideTransaction
     * @throws ApplicationLayerException
     */
    public function transactionalFileUpload(FileToStore $fileToStore, string $destinationPath, callable $functionToExecuteInsideTransaction): void;
}