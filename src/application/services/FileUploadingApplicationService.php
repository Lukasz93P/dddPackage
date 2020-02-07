<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\application\services;


use Lukasz93P\dddPackage\application\exceptions\ApplicationLayerException;
use Lukasz93P\dddPackage\domain\exceptions\DomainException;
use Lukasz93P\dddPackage\domain\persistence\TransactionManager;
use Lukasz93P\dddPackage\shared\Logger;
use Lukasz93P\SymfonyHttpApi\filesStorage\FilesStorage;
use Lukasz93P\SymfonyHttpApi\filesStorage\FileToStore;
use Throwable;

abstract class FileUploadingApplicationService extends ApplicationService
{
    protected FilesStorage $filesStorage;

    protected function __construct(TransactionManager $transactionManager, Logger $logger, FilesStorage $filesStorage)
    {
        parent::__construct($transactionManager, $logger);
        $this->filesStorage = $filesStorage;
    }

    /**
     * @param FileToStore $fileToStore
     * @param string $destinationPath
     * @param callable $functionToExecuteInsideTransaction
     * @throws ApplicationLayerException
     */
    protected function transactionalFileUpload(FileToStore $fileToStore, string $destinationPath, callable $functionToExecuteInsideTransaction): void
    {
        $fileAddingResult = null;
        try {
            $fileAddingResult = $this->filesStorage->add($fileToStore, $destinationPath);
            $this->transactional(fn() => $functionToExecuteInsideTransaction($fileAddingResult));
        } catch (Throwable $throwable) {
            $this->log($throwable);
            $this->filesStorage->remove($fileAddingResult ? $fileAddingResult->newPath() : '');
            throw $throwable instanceof DomainException
                ? ApplicationLayerException::withProvidedMessage($throwable->getMessage())
                : ApplicationLayerException::withGenericMessage();
        }
    }

}