<?php

declare(strict_types=1);

namespace App\Service;

use App\Collection\ItemCollectionInterface;
use App\DTO\ProduceInterface;
use App\Enum\ProduceType;
use App\Factory\ProduceCollectionFactoryInterface;
use Symfony\Component\HttpFoundation\Exception\UnexpectedValueException;

final readonly class CollectionManagementService
{
    public function __construct(
        private ProduceCollectionFactoryInterface $produceCollectionFactory,
        private CollectionStorageServiceInterface $collectionStorageService,
    ) {
    }

    /**
     * @throws UnexpectedValueException
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
        $fruitCollection = $this->produceCollectionFactory->generateCollection(ProduceType::FRUIT);
        $vegetableCollection = $this->produceCollectionFactory->generateCollection(ProduceType::VEGETABLE);

        foreach ($produces as $produce) {
            if ($produce->getType() === ProduceType::FRUIT) {
                $fruitCollection->add($produce);
            } else {
                $vegetableCollection->add($produce);
            }
        }

        $this->collectionStorageService->update(ProduceType::FRUIT, $fruitCollection);
        $this->collectionStorageService->update(ProduceType::VEGETABLE, $vegetableCollection);

        return [
            'fruit' => $fruitCollection,
            'vegetable' => $vegetableCollection
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