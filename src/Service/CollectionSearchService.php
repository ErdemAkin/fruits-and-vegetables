<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Filter\FilterInterface;
use App\DTO\ProduceInterface;
use App\Factory\ProduceCollectionFactory;

class CollectionSearchService
{
    public function __construct(
        private ProduceCollectionFactory $produceCollectionFactory,
    ) {
    }

    public function search(FilterInterface $filter): ?ProduceInterface
    {
        return $this->produceCollectionFactory->generateSearchableCollection()->search($filter);
    }
}