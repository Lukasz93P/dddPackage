<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\domain\aggregates;


use Lukasz93P\tasksQueue\events\eventRecorder\BaseEventRecorder;

abstract class BaseAggregate extends BaseEventRecorder implements Aggregate
{
    public function equals(Aggregate $aggregate): bool
    {
        if (!$aggregate instanceof self) {
            return false;
        }

        return $this->id()->equals($aggregate->id());
    }

}