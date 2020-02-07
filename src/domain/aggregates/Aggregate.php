<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\domain\aggregates;


use Lukasz93P\DoctrineDomainIdTypes\domainId\AggregateId;
use Lukasz93P\tasksQueue\events\eventRecorder\EventRecorder;

interface Aggregate extends EventRecorder
{
    public function equals(Aggregate $aggregate): bool;

    public function id(): AggregateId;
}