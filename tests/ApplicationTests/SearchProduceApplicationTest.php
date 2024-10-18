<?php

declare(strict_types=1);

namespace App\Tests\ApplicationTests;

use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SearchProduceApplicationTest extends WebTestCase
{
    public function setUp(): void
    {
        parent::setUp();

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
    }

    /**
     * @dataProvider filterDataProvider
     */
    public function testSearchProduceWithName(array $filter, array $result): void
    {
        $client = self::getClient();
        $client->jsonRequest(
            'POST',
            '/search/',
            $filter
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $responseBody = json_decode((string)$client->getResponse()->getContent(), true);
        $this->assertEquals($result['id'], $responseBody['id']);
        $this->assertEquals($result['name'], $responseBody['name']);
        $this->assertEquals($result['type'], $responseBody['type']);
        $this->assertEquals($result['quantity'], $responseBody['quantity']);
        $this->assertEquals($result['unit'], $responseBody['unit']);
    }

    public function filterDataProvider(): Generator
    {
        yield 'Name search' => [
            'filter' => [
                'field' => 'name',
                'value' => 'Melon'
            ],
            'result' => [
                'id' => 5,
                'name' => 'Melon',
                'type' => 'fruit',
                'quantity' => 1200,
                'unit' => 'g'
            ]
        ];

        yield 'Id Search' => [
            'filter' => [
                'field' => 'id',
                'value' => 3
            ],
            'result' => [
                'id' => 3,
                'name' => 'Beans',
                'type' => 'vegetable',
                'quantity' => 2000,
                'unit' => 'g'
            ]
        ];
    }

    public function testSearchProduceWithUnExpectedFilter(): void
    {
        $client = self::getClient();
        $client->jsonRequest(
            'POST',
            '/search/',
            [
                'field' => 'quantity',
                'value' => 1000
            ]
        );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('"This filter is not defined."', $client->getResponse()->getContent());
    }
}