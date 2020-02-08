<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\infrastructure\transactionalFunction;


use Lukasz93P\dddPackage\application\exceptions\ApplicationLayerException;
use Lukasz93P\dddPackage\domain\exceptions\DomainException;
use Lukasz93P\dddPackage\domain\persistence\TransactionManager;
use Lukasz93P\dddPackage\domain\shared\TransactionalFunction;
use Lukasz93P\dddPackage\shared\Logger;
use Lukasz93P\SymfonyHttpApi\filesStorage\FilesStorage;
use Lukasz93P\SymfonyHttpApi\filesStorage\FileToStore;
use Throwable;

class ErrorsLoggingTransactionalFunction implements TransactionalFunction
{
    private TransactionManager $transactionManager;

    private Logger $logger;

    private FilesStorage $filesStorage;

    public function transactional(callable $functionToExecuteInsideTransaction): void
    {
        try {
            $this->transactionManager->transactional($functionToExecuteInsideTransaction);
        } catch (DomainException $domainException) {
            $this->logger->logThrowable($domainException);
            throw ApplicationLayerException::withProvidedMessage($domainException->getMessage());
        } catch (Throwable $exception) {
            $this->logger->logThrowable($exception);
            throw ApplicationLayerException::withGenericMessage();
        }
    }

    public function transactionalFileUpload(FileToStore $fileToStore, string $destinationPath, callable $functionToExecuteInsideTransaction): void
    {
        $fileAddingResult = null;
        try {
            $fileAddingResult = $this->filesStorage->add($fileToStore, $destinationPath);
            $this->transactional(fn() => $functionToExecuteInsideTransaction($fileAddingResult));
        } catch (Throwable $throwable) {
            $this->logger->logThrowable($throwable);
            $this->filesStorage->remove($fileAddingResult ? $fileAddingResult->newPath() : '');
            throw $throwable instanceof DomainException
                ? ApplicationLayerException::withProvidedMessage($throwable->getMessage())
                : ApplicationLayerException::withGenericMessage();
        }
    }

}