<?php

declare(strict_types=1);

namespace App\Tests\ApplicationTests;

use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ListProduceApplicationTest extends WebTestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testExpectAllFruitWithHappyFlow(string $type): void
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
            'GET',
            sprintf('/list/%s/', $type),
            $payload
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        foreach ($payload as $item) {
            if ($item['type'] === $type) {
                self::assertStringContainsString($item['name'], $client->getResponse()->getContent());
            } else {
                self::assertStringNotContainsString($item['name'], $client->getResponse()->getContent());
            }
        }
    }

    public function dataProvider(): Generator
    {
        yield 'fruit' => [
            'fruit'
        ];

        yield 'vegetable' => [
            'vegetable'
        ];
    }
}