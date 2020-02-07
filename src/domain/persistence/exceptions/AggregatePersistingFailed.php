<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\domain\persistence\exceptions;


use RuntimeException;
use Throwable;

class AggregatePersistingFailed extends RuntimeException
{
    public static function fromReason(Throwable $reason): self
    {
        return new self("Aggregate could not been saved. Reason: {$reason->getMessage()}", 422, $reason);
    }

    private function __construct($message = '', $code = 422, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}