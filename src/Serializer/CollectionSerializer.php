<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Collection\ItemCollectionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final readonly class CollectionSerializer implements NormalizerInterface
{
    public function __construct(
        private readonly NormalizerInterface $produceSerializer,
    ) {
    }

    /**
     * @param ItemCollectionInterface $object
     */
    public function normalize(
        mixed $object,
        ?string $format = null,
        array $context = []
    ): array {
        $response = [];
        foreach ($object->list() as $data) {
            $response[] = $this->produceSerializer->normalize($data, context: $context);
        }

        return $response;
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof ItemCollectionInterface;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            ItemCollectionInterface::class => true,
        ];
    }
}