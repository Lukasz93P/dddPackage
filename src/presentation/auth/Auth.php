<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\presentation\auth;


interface Auth
{
    public function user(): User;
}