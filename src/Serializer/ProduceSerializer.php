<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Converter\ConverterInterface;
use App\DTO\ProduceInterface;
use App\Enum\Unit;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final readonly class ProduceSerializer implements NormalizerInterface
{
    public const CONVERT_TO_KILOGRAM = 'convertToKilogram';

    public function __construct(
        private ConverterInterface $toKilogramConverter,
    ) {
    }

    /**
     * @param ProduceInterface $object
     */
    public function normalize(
        mixed $object,
        ?string $format = null,
        array $context = []
    ): array {
        $quantity = $object->getQuantity();
        $unit = $object->getUnit();

        if (isset($context[self::CONVERT_TO_KILOGRAM]) === true && $context[self::CONVERT_TO_KILOGRAM] === true) {
            $quantity = $this->toKilogramConverter->convert($quantity);
            $unit = Unit::KILOGRAM;
        }

        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'type' => $object->getType(),
            'quantity' => $quantity,
            'unit' => $unit,
        ];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof ProduceInterface;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            ProduceInterface::class => true,
        ];
    }
}