<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\shared;


use Throwable;

abstract class LoggerWithPreparedErrorInfo implements Logger
{
    public function logThrowable(Throwable $throwable): void
    {
        $this->saveErrorInfo(
            'ERROR -> ' . $throwable->getMessage() . ' in -> ' . $throwable->getFile() . ' at line -> '
            . $throwable->getLine() . ' stack trace -> ' . $throwable->getTraceAsString()
        );
    }

    abstract protected function saveErrorInfo(string $errorInfo): void;
}