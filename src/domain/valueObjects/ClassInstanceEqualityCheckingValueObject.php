<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\domain\valueObjects;


abstract class ClassInstanceEqualityCheckingValueObject implements ValueObject
{
    public function equals(ValueObject $other): bool
    {
        return $other instanceof static;
    }

}