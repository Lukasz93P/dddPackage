<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\application\services;

use Lukasz93P\dddPackage\application\exceptions\ApplicationLayerException;
use Lukasz93P\dddPackage\domain\shared\TransactionalFunction;
use Lukasz93P\SymfonyHttpApi\filesStorage\FileToStore;
use Lukasz93P\tasksQueue\outbox\Outbox;
use Lukasz93P\tasksQueue\outbox\OutboxFactory;
use Lukasz93P\tasksQueue\PublishableAsynchronousTask;

abstract class ApplicationService
{
    private TransactionalFunction $transactionalFunction;

    private Outbox $outbox;

    protected function __construct(TransactionalFunction $transactionalFunction, Outbox $outbox = null)
    {
        $this->transactionalFunction = $transactionalFunction;
        $this->outbox = $outbox ?? OutboxFactory::create([]);
    }

    /**
     * @param callable $functionToExecuteInsideTransaction
     * @return void
     * @throws ApplicationLayerException
     */
    protected function transactional(callable $functionToExecuteInsideTransaction): void
    {
        $this->transactionalFunction->transactional($functionToExecuteInsideTransaction);
    }

    /**
     * @param FileToStore $fileToStore
     * @param string $destinationPath
     * @param callable $functionToExecuteInsideTransaction
     * @throws ApplicationLayerException
     */
    protected function transactionalFileUpload(FileToStore $fileToStore, string $destinationPath, callable $functionToExecuteInsideTransaction): void
    {
        $this->transactionalFunction->transactionalFileUpload($fileToStore, $destinationPath, $functionToExecuteInsideTransaction);
    }

    /**
     * @param PublishableAsynchronousTask[] $events
     */
    protected function saveEvents(array $events): void
    {
        $this->outbox->add($events);
    }

}