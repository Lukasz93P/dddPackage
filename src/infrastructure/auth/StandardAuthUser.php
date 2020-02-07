<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\infrastructure\auth;


use Lukasz93P\dddPackage\presentation\auth\User;

class StandardAuthUser implements User
{
    private string $identifier;

    public static function fromIdentifier(string $identifier):self {
        return new self($identifier);
    }

    private function __construct(string $identifier)
    {
        $this->identifier = $identifier;
    }

    public function identifier(): string
    {
        return $this->identifier;
    }

}