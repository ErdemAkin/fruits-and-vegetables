<?php

declare(strict_types=1);

namespace App\Service;

use App\Collection\ItemCollectionInterface;
use App\Enum\ProduceType;

interface CollectionStorageServiceInterface
{
    public function update(ProduceType $type, ItemCollectionInterface $collection): void;
}