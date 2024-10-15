<?php

declare(strict_types=1);

namespace App\Collection;

use App\DTO\Filter\FilterInterface;
use App\DTO\ProduceInterface;
use Symfony\Component\HttpFoundation\Exception\UnexpectedValueException;

class ItemCollection implements SearchableCollectionInterface
{
    protected array $items = [];

    /**
     * @throws UnexpectedValueException
     */
    public function add(ProduceInterface $item): void
    {
        if (isset($this->items[$item->getId()]) === true) {
            throw new UnexpectedValueException('Item already exists.');
        }
        $this->items[$item->getId()] = $item;
    }

    public function list(): array
    {
        return $this->items;
    }

    public function remove(int $id): void
    {
        unset($this->items[$id]);
    }

    public function search(FilterInterface $filter): ?ProduceInterface
    {
        foreach ($this->items as $item) {
            if ($item->get($filter->getField()) === $filter->getValue()) {
                return $item;
            }
        }
        return null;
    }
}