<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\application\services;

use Lukasz93P\dddPackage\application\exceptions\ApplicationLayerException;
use Lukasz93P\dddPackage\domain\exceptions\DomainException;
use Lukasz93P\dddPackage\domain\persistence\TransactionManager;
use Lukasz93P\dddPackage\shared\Logger;
use Lukasz93P\tasksQueue\outbox\Outbox;
use Lukasz93P\tasksQueue\outbox\OutboxFactory;
use Lukasz93P\tasksQueue\PublishableAsynchronousTask;
use Throwable;

abstract class ApplicationService
{
    private TransactionManager $transactionManager;

    private Outbox $outbox;

    private Logger $logger;

    protected function __construct(TransactionManager $transactionManager, Logger $logger, Outbox $outbox = null)
    {
        $this->transactionManager = $transactionManager;
        $this->logger = $logger;
        $this->outbox = $outbox ?? OutboxFactory::create([]);
    }

    /**
     * @param callable $functionToExecuteInsideTransaction
     * @return void
     * @throws ApplicationLayerException
     */
    protected function transactional(callable $functionToExecuteInsideTransaction): void
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

    /**
     * @param PublishableAsynchronousTask[] $events
     */
    protected function saveEvents(array $events): void
    {
        $this->outbox->add($events);
    }

    protected function log(Throwable $throwable): void
    {
        $this->logger->logThrowable($throwable);
    }

}