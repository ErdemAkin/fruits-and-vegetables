<?php

declare(strict_types=1);

namespace App\Factory;

use App\Collection\ItemCollection;
use App\Collection\ItemCollectionInterface;
use App\Collection\SearchableCollectionInterface;
use App\DTO\Fruit;
use App\DTO\Vegatable;
use App\Entity\CollectionEntity;
use App\Enum\ProduceType;
use App\Repository\CollectionRepository;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final readonly class ProduceCollectionFactory implements ProduceCollectionFactoryInterface
{
    public function __construct(
        private CollectionRepository $collectionRepository,
        private DenormalizerInterface $denormalizer,
    ) {
    }

    public function generateCollection(ProduceType $type): ItemCollectionInterface
    {
        $collectionEntity = $this->collectionRepository->findOneBy(['type' => $type->value]);
        $itemCollection = new ItemCollection();

        return $this->create(
            $itemCollection,
            $type,
            $collectionEntity
        );
    }

    public function generateSearchableCollection(): SearchableCollectionInterface
    {
        $collectionEntities = $this->collectionRepository->findAll();

        $itemCollection = new ItemCollection();
        foreach ($collectionEntities as $collectionEntity) {
            $itemCollection = $this->create(
                $itemCollection,
                $collectionEntity->getType(),
                $collectionEntity
            );
        }

        return $itemCollection;
    }

    private function create(
        ItemCollection $itemCollection,
        ProduceType $type,
        ?CollectionEntity $collectionEntity
    ): ItemCollectionInterface {
        if ($collectionEntity === null) {
            return $itemCollection;
        }

        foreach ($collectionEntity->getCollection() as $data) {
            $target = match ($type) {
                ProduceType::FRUIT => Fruit::class,
                default => Vegatable::class,
            };
            $item = $this->denormalizer->denormalize($data, $target);
            if ($item === null) {
                continue;
            }
            $itemCollection->add($item);
        }

        return $itemCollection;
    }
}