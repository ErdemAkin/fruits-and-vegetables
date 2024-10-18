<?php

declare(strict_types=1);

namespace App\Service;

use App\Collection\ItemCollectionInterface;
use App\DTO\ProduceInterface;
use App\Enum\ProduceType;
use App\Exception\ItemAlreadyExistsException;
use App\Factory\ProduceCollectionFactoryInterface;

final readonly class CollectionManagementService implements CollectionManagementServiceInterface
{
    public function __construct(
        private ProduceCollectionFactoryInterface $produceCollectionFactory,
        private CollectionStorageServiceInterface $collectionStorageService,
    ) {
    }

    /**
     * @throws ItemAlreadyExistsException
     */
    public function add(ProduceInterface $input): ItemCollectionInterface
    {
        $collection = $this->produceCollectionFactory->generateCollection($input->getType());
        $collection->add($input);

        $this->collectionStorageService->update($input->getType(), $collection);

        return $collection;
    }

    /**
     * @param ProduceInterface[] $produces
     * @return ItemCollectionInterface[]
     */
    public function addBulk(array $produces): array
    {
        $fruitCollection = null;
        $vegetableCollection = null;

        foreach ($produces as $produce) {
            if ($produce->getType() === ProduceType::FRUIT) {
                if ($fruitCollection === null) {
                    $fruitCollection = $this->produceCollectionFactory->generateCollection(ProduceType::FRUIT);
                }
                $fruitCollection->add($produce);
            } else {
                if ($vegetableCollection === null) {
                    $vegetableCollection = $this->produceCollectionFactory->generateCollection(ProduceType::VEGETABLE);
                }
                $vegetableCollection->add($produce);
            }
        }

        if ($fruitCollection !== null) {
            $this->collectionStorageService->update(ProduceType::FRUIT, $fruitCollection);
        }

        if ($vegetableCollection !== null) {
            $this->collectionStorageService->update(ProduceType::VEGETABLE, $vegetableCollection);
        }

        return [
            'fruit' => $fruitCollection,
            'vegetable' => $vegetableCollection,
        ];
    }

    public function list(ProduceType $type): ItemCollectionInterface
    {
        return $this->produceCollectionFactory->generateCollection($type);
    }

    public function remove(ProduceType $type, int $id): void
    {
        $collection = $this->produceCollectionFactory->generateCollection($type);
        $collection->remove($id);

        $this->collectionStorageService->update($type, $collection);
    }
}