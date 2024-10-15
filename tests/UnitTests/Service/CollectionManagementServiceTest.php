<?php

declare(strict_types=1);

namespace App\Tests\UnitTests\Service;

use App\Collection\ItemCollectionInterface;
use App\DTO\ProduceInterface;
use App\Enum\ProduceType;
use App\Factory\ProduceCollectionFactoryInterface;
use App\Service\CollectionManagementService;
use App\Service\CollectionStorageServiceInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CollectionManagementServiceTest extends KernelTestCase
{
    public function testAddFunction(): void
    {
        self::bootKernel();
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

        $service = $container->get(CollectionManagementService::class);
        $service->add($produce);
    }
}