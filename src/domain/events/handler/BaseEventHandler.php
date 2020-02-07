<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\domain\events\handler;


use Lukasz93P\dddPackage\domain\events\handler\exceptions\UnsupportedEventTypePassedToHandler;
use Lukasz93P\dddPackage\domain\persistence\TransactionManager;
use Lukasz93P\tasksQueue\events\Event;
use Lukasz93P\tasksQueue\ProcessableAsynchronousTask;
use Lukasz93P\tasksQueue\TaskHandler;

abstract class BaseEventHandler implements TaskHandler
{
    private TransactionManager $transactionManager;

    protected function __construct(TransactionManager $transactionManager)
    {
        $this->transactionManager = $transactionManager;
    }

    /**
     * @param ProcessableAsynchronousTask|Event $event
     */
    public function handle(ProcessableAsynchronousTask $event): void
    {
        if (!in_array(get_class($event), $this->provideClassNamesForSupportedEvents(), true)) {
            throw UnsupportedEventTypePassedToHandler::fromHandlerAndEvent($this, $event);
        }

        $this->transactionManager->transactional(fn() => $this->eventHandlingLogic($event));
    }

    abstract protected function eventHandlingLogic(Event $event): void;

    /**
     * @return string[]
     */
    abstract protected function provideClassNamesForSupportedEvents(): array;
}