<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\application\query;


abstract class Query
{
    private string $statement;

    private array $valuesToBind;

    protected function __construct(string $statement, array $valuesToBind = [])
    {
        $this->statement = $statement;
        $this->valuesToBind = $valuesToBind;
    }

    public function getStatement(): string
    {
        return $this->statement;
    }

    public function getValuesToBind(): array
    {
        return $this->valuesToBind;
    }

    abstract public function expectsMultipleRows(): bool;
}