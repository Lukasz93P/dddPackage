<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\application\query\exceptions;


use RuntimeException;
use Throwable;

class QueryResultNotFoundException extends RuntimeException
{
    public static function create(): self
    {
        return new self('Requested data not found.');
    }

    private function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}