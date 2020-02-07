<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\domain\valueObjects;


interface ValueObject
{
    public function equals(ValueObject $other): bool;
}