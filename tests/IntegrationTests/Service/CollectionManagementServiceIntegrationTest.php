<?php

declare(strict_types=1);

namespace App\Tests\IntegrationTests\Service;

use App\Collection\ItemCollectionInterface;
use App\DTO\Fruit;
use App\Enum\ProduceType;
use App\Enum\Unit;
use App\Repository\CollectionRepository;
use App\Service\CollectionManagementServiceInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CollectionManagementServiceIntegrationTest extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
    }

    public function testAddFunction(): void
    {
        $container = static::getContainer();

        $produce = new Fruit();
        $produce->setId(1);
        $produce->setName('Produce');
        $produce->setQuantity(1000);
        $produce->setUnit(Unit::GRAM);

        $collectionManagementService = $container->get(CollectionManagementServiceInterface::class);
        $repository = $container->get(CollectionRepository::class);

        $resultCollection = $collectionManagementService->add($produce);
        $databaseData = $repository->findBy(['type' => ProduceType::FRUIT]);
        $databaseCollection = $databaseData[0]->getCollection()[0];

        $this->assertInstanceOf(ItemCollectionInterface::class, $resultCollection);
        $this->assertEquals($resultCollection->list()[1], $produce);
        $this->assertEquals($databaseCollection['id'], $produce->getId());
        $this->assertEquals($databaseCollection['name'], $produce->getName());
        $this->assertEquals($databaseCollection['type'], $produce->getType());
        $this->assertEquals($databaseCollection['quantity'], $produce->getQuantity());
        $this->assertEquals($databaseCollection['unit'], $produce->getUnit());
    }


}