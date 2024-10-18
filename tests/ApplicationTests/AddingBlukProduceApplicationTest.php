<?php

declare(strict_types=1);

namespace App\Tests\ApplicationTests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddingBlukProduceApplicationTest extends WebTestCase
{
    public function testExpectAddingBulkProduceWithHappyFlow(): void
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

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $responseBody = json_decode((string)$client->getResponse()->getContent(), true);
        self::assertCount(2, $responseBody);
        self::assertCount(3, $responseBody['fruit']);
        self::assertCount(2, $responseBody['vegetable']);
    }

    public function testExpectAddingBulkProduceWithEmptyPayload(): void
    {
        $client = self::createClient();
        $client->jsonRequest(
            'POST',
            '/bulk/'
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $responseBody = json_decode((string)$client->getResponse()->getContent(), true);
        self::assertCount(2, $responseBody);
        self::assertNull($responseBody['fruit']);
        self::assertNull($responseBody['vegetable']);
    }
}