<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\application\exceptions;


use RuntimeException;
use Throwable;

class ApplicationLayerException extends RuntimeException
{
    public static function withProvidedMessage(string $message): self
    {
        return new self($message);
    }

    public static function withGenericMessage(): self
    {
        return new self('Error has occurred, please try again later');
    }

    private function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}