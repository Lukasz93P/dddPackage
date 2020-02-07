<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\domain\events\handler\exceptions;


use Lukasz93P\tasksQueue\events\Event;
use Lukasz93P\tasksQueue\TaskHandler;
use RuntimeException;
use Throwable;

class UnsupportedEventTypePassedToHandler extends RuntimeException
{
    public static function fromHandlerAndEvent(TaskHandler $handler, Event $event): self
    {
        return new self('Event of class: ' . get_class($event) . ' unsupported by ' . get_class($handler));
    }

    private function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}