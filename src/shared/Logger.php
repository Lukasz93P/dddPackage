<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\shared;


use Throwable;

interface Logger
{
    public function logThrowable(Throwable $throwable): void;
}