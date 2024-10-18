<?php

declare(strict_types=1);

namespace App\Service;

use App\Collection\ItemCollectionInterface;
use App\DTO\ProduceInterface;
use App\Enum\ProduceType;
use App\Exception\ItemAlreadyExistsException;

interface CollectionManagementServiceInterface
{
    /**
     * @throws ItemAlreadyExistsException
     */
    public function add(ProduceInterface $input): ItemCollectionInterface;

    /**
     * @param ProduceInterface[] $produces
     * @return ItemCollectionInterface[]
     */
    public function addBulk(array $produces): array;

    public function list(ProduceType $type): ItemCollectionInterface;

    public function remove(ProduceType $type, int $id): void;
}