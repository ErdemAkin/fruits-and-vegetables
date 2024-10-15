<?php

declare(strict_types=1);

namespace App\Collection;

use App\DTO\Filter\FilterInterface;
use App\DTO\ProduceInterface;

interface SearchableCollectionInterface extends ItemCollectionInterface
{
    public function search(FilterInterface $filter): ?ProduceInterface;
}