<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\application\query;


use InvalidArgumentException;

class PaginatedQueryResult
{
    private array $data;

    private int $count;

    public static function fromDataAndRowsCount(array $data, int $rowsCount): self
    {
        if (!$data) {
            throw new InvalidArgumentException('Data cannot be empty.');
        }
        if ($rowsCount < 1) {
            throw new InvalidArgumentException('Rows count cannot be negative');
        }

        return new self($data, $rowsCount);
    }

    private function __construct(array $data, int $count)
    {
        $this->data = $data;
        $this->count = $count;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function toArray(): array
    {
        return ['data' => $this->getData(), 'count' => $this->getCount()];
    }

}