<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\presentation\auth;


interface User
{
    public function identifier(): string;
}