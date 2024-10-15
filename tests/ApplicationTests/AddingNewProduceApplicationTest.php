<?php

declare(strict_types=1);

namespace App\Tests\ApplicationTests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddingNewProduceApplicationTest extends WebTestCase
{
    public function testExpectAddingNewProduceWithHappyFlow(): void
    {
        $payload = [
            'id' => 1,
            'name' => 'Carrot',
            'type' => 'vegetable',
            'quantity' => 2000,
            'unit' => 'g'
        ];

        $client = self::createClient();
        $client->jsonRequest(
            'POST',
            '/add/',
            $payload
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $responseBody = json_decode((string)$client->getResponse()->getContent(), true);
        $this->assertEquals($payload['id'], $responseBody[0]['id']);
        $this->assertEquals($payload['name'], $responseBody[0]['name']);
        $this->assertEquals($payload['type'], $responseBody[0]['type']);
        $this->assertEquals($payload['quantity'], $responseBody[0]['quantity']);
        $this->assertEquals($payload['unit'], $responseBody[0]['unit']);
    }

    public function testExpectAddingNewProduceWithUnitIsKilogram(): void
    {
        $payload = [
            'id' => 1,
            'name' => 'Carrot',
            'type' => 'vegetable',
            'quantity' => 3,
            'unit' => 'kg'
        ];

        $client = self::createClient();
        $client->jsonRequest(
            'POST',
            '/add/',
            $payload
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $responseBody = json_decode((string)$client->getResponse()->getContent(), true);
        $this->assertEquals($payload['id'], $responseBody[0]['id']);
        $this->assertEquals($payload['name'], $responseBody[0]['name']);
        $this->assertEquals($payload['type'], $responseBody[0]['type']);
        $this->assertEquals('3000', $responseBody[0]['quantity']);
        $this->assertEquals('g', $responseBody[0]['unit']);
    }

    public function testExpectReturnBadRequestWhenAddDuplicateProduce(): void
    {
        $payload = [
            'id' => 1,
            'name' => 'Carrot',
            'type' => 'vegetable',
            'quantity' => 3,
            'unit' => 'kg'
        ];

        $client = self::createClient();
        $client->jsonRequest(
            'POST',
            '/add/',
            $payload
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $responseBody = json_decode((string)$client->getResponse()->getContent(), true);
        $this->assertEquals($payload['id'], $responseBody[0]['id']);
        $this->assertEquals($payload['name'], $responseBody[0]['name']);
        $this->assertEquals($payload['type'], $responseBody[0]['type']);
        $this->assertEquals('3000', $responseBody[0]['quantity']);
        $this->assertEquals('g', $responseBody[0]['unit']);

        $client->jsonRequest(
            'POST',
            '/add/',
            $payload
        );
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}