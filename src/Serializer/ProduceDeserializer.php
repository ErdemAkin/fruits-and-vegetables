<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Converter\ConverterInterface;
use App\DTO\Fruit;
use App\DTO\ProduceInterface;
use App\DTO\Vegatable;
use App\Enum\ProduceType;
use App\Enum\Unit;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final readonly class ProduceDeserializer implements DenormalizerInterface
{
    public function __construct(private ConverterInterface $toGramConverter)
    {
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            ProduceInterface::class => true,
        ];
    }

    public function denormalize(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = []
    ): ?ProduceInterface {
        $item = match (ProduceType::from($data['type'])) {
            ProduceType::FRUIT => new Fruit(),
            default => new Vegatable(),
        };

        $item->setId($data['id']);
        $item->setName($data['name']);
        $item->setUnit(Unit::GRAM);

        $quantity = $data['quantity'];
        if (Unit::tryFrom($data['unit']) === Unit::KILOGRAM) {
            $quantity = $this->toGramConverter->convert($quantity);
        }

        $item->setQuantity($quantity);

        return $item;
    }

    public function supportsDenormalization(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = []
    ): bool {
        return $type === ProduceInterface::class;
    }
}