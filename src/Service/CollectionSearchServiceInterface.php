<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Filter\FilterInterface;
use App\DTO\ProduceInterface;

interface CollectionSearchServiceInterface
{
    public function search(FilterInterface $filter): ?ProduceInterface;
}