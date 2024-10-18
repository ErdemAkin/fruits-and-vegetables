<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Filter\FilterInterface;
use App\DTO\ProduceInterface;
use App\Factory\ProduceCollectionFactoryInterface;

final readonly class CollectionSearchService implements CollectionSearchServiceInterface
{
    public function __construct(
        private ProduceCollectionFactoryInterface $produceCollectionFactory,
    ) {
    }

    public function search(FilterInterface $filter): ?ProduceInterface
    {
        return $this->produceCollectionFactory->generateSearchableCollection()->search($filter);
    }
}