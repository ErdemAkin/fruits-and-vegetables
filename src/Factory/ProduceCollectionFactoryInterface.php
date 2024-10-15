<?php

declare(strict_types=1);

namespace App\Factory;

use App\Collection\ItemCollectionInterface;
use App\Collection\SearchableCollectionInterface;
use App\Enum\ProduceType;

interface ProduceCollectionFactoryInterface
{
    public function generateCollection(ProduceType $type): ItemCollectionInterface;

    public function generateSearchableCollection(): SearchableCollectionInterface;
}