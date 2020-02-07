<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\domain\persistence\exceptions;


use RuntimeException;
use Throwable;

class AggregateNotFound extends RuntimeException
{
    public static function create(): self
    {
        return new self('Aggregate not found.');
    }

    private function __construct($message = '', $code = 404, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}