<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\domain\events;


use Lukasz93P\tasksQueue\events\Event;
use Lukasz93P\tasksQueue\events\EventId;

abstract class BasePublishableEvent extends Event
{
    protected function __construct(EventId $id, string $aggregateId, string $routingKey = '', string $classIdentificationKey = '')
    {
        parent::__construct($id, $routingKey ?: 'default', getenv('EVENTS_TOPIC'), $classIdentificationKey ?: get_class($this), $aggregateId);
    }

}