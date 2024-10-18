<?php

declare(strict_types=1);

namespace App\Tests\UnitTests\Service;

use App\Collection\ItemCollectionInterface;
use App\DTO\ProduceInterface;
use App\Enum\ProduceType;
use App\Factory\ProduceCollectionFactoryInterface;
use App\Service\CollectionManagementServiceInterface;
use App\Service\CollectionStorageServiceInterface;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CollectionManagementServiceTest extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
    }

    public function testAddFunction(): void
    {
        $container = static::getContainer();

        $type = ProduceType::FRUIT;

        $produce = $this->createStub(ProduceInterface::class);
        $produce->method('getType')->willReturn($type);

        $collection = $this->createMock(ItemCollectionInterface::class);
        $collection->expects(self::once())
            ->method('add')
            ->with($produce);

        $factoryService = $this->createMock(ProduceCollectionFactoryInterface::class);
        $factoryService->expects(self::once())
            ->method('generateCollection')
            ->with($type)
            ->willReturn($collection);

        $storageService = $this->createMock(CollectionStorageServiceInterface::class);
        $storageService->expects(self::once())
            ->method('update')
            ->with($type, $collection);

        $container->set(ProduceCollectionFactoryInterface::class, $factoryService);
        $container->set(CollectionStorageServiceInterface::class, $storageService);

        $service = $container->get(CollectionManagementServiceInterface::class);
        $service->add($produce);
    }

    /**
     * @dataProvider bulkTestDataProvider
     */
    public function testAddBulkFunctionWithCollectionHasOnlyOneTypeProduce(
        ProduceType $existingType,
        ProduceType $missingType
    ): void {
        $container = static::getContainer();

        $produce = $this->createStub(ProduceInterface::class);
        $produce->method('getType')->willReturn($existingType);

        $collection = $this->createMock(ItemCollectionInterface::class);
        $collection->expects(self::once())
            ->method('add')
            ->with($produce);

        $factoryService = $this->createMock(ProduceCollectionFactoryInterface::class);
        $factoryService->expects(self::once())
            ->method('generateCollection')
            ->with($existingType)
            ->willReturn($collection);

        $storageService = $this->createMock(CollectionStorageServiceInterface::class);
        $storageService->expects(self::once())
            ->method('update')
            ->with($existingType, $collection);

        $container->set(ProduceCollectionFactoryInterface::class, $factoryService);
        $container->set(CollectionStorageServiceInterface::class, $storageService);

        $service = $container->get(CollectionManagementServiceInterface::class);
        $return = $service->addBulk([$produce]);

        self::assertNotNull($return[$existingType->value]);
        self::assertNull($return[$missingType->value]);
    }

    public function bulkTestDataProvider(): Generator
    {
        yield 'Collection has only fruits' => [
            'existingType' => ProduceType::FRUIT,
            'missingType' => ProduceType::VEGETABLE,
        ];
        yield 'Collection has only vegetables' => [
            'existingType' => ProduceType::VEGETABLE,
            'missingType' => ProduceType::FRUIT,
        ];
    }

    public function testAddBulkFunctionWithCollectionHasOnlyBothTypeProduce(): void
    {
        $container = static::getContainer();

        $fruitProduce = $this->createStub(ProduceInterface::class);
        $fruitProduce->method('getType')->willReturn(ProduceType::FRUIT);

        $vegetableProduce = $this->createStub(ProduceInterface::class);
        $vegetableProduce->method('getType')->willReturn(ProduceType::VEGETABLE);

        $collection = $this->createMock(ItemCollectionInterface::class);
        $collection->expects(self::exactly(2))
            ->method('add');

        $factoryService = $this->createMock(ProduceCollectionFactoryInterface::class);
        $factoryService->expects(self::exactly(2))
            ->method('generateCollection')
            ->willReturn($collection);

        $storageService = $this->createMock(CollectionStorageServiceInterface::class);
        $storageService->expects(self::exactly(2))
            ->method('update');

        $container->set(ProduceCollectionFactoryInterface::class, $factoryService);
        $container->set(CollectionStorageServiceInterface::class, $storageService);

        $service = $container->get(CollectionManagementServiceInterface::class);
        $return = $service->addBulk([$fruitProduce, $vegetableProduce]);

        self::assertNotNull($return[ProduceType::FRUIT->value]);
        self::assertNotNull($return[ProduceType::VEGETABLE->value]);
    }
}