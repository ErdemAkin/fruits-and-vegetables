<?php

declare(strict_types=1);

namespace App\Tests\ApplicationTests;

use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RemoveProduceApplicationTest extends WebTestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testRemoveProduceWithHappyFlow(string $type, int $id): void
    {
        $payload = [
            [
                'id' => 1,
                'name' => 'Carrot',
                'type' => 'vegetable',
                'quantity' => 2000,
                'unit' => 'g'
            ],
            [
                'id' => 2,
                'name' => 'Apple',
                'type' => 'fruit',
                'quantity' => 30,
                'unit' => 'kg'
            ],
            [
                'id' => 3,
                'name' => 'Beans',
                'type' => 'vegetable',
                'quantity' => 2,
                'unit' => 'kg'
            ],
            [
                'id' => 4,
                'name' => 'Banana',
                'type' => 'fruit',
                'quantity' => 1200,
                'unit' => 'g'
            ],
            [
                'id' => 5,
                'name' => 'Melon',
                'type' => 'fruit',
                'quantity' => 1200,
                'unit' => 'g'
            ],
        ];

        $client = self::createClient();
        $client->jsonRequest(
            'POST',
            '/bulk/',
            $payload
        );

        $client->jsonRequest(
            'DELETE',
            sprintf('/%s/%s/', $type, $id),
            $payload
        );

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }

    public function dataProvider(): Generator
    {
        yield 'fruit' => [
            'fruit',
            2
        ];

        yield 'vegetable' => [
            'vegetable',
            1
        ];
    }
}