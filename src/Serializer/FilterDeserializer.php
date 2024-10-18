<?php

declare(strict_types=1);

namespace App\Serializer;

use App\DTO\Filter\FilterInterface;
use App\DTO\Filter\IdFilter;
use App\DTO\Filter\NameFilter;
use App\Enum\FilterField;
use App\Exception\UndefinedFilterException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final readonly class FilterDeserializer implements DenormalizerInterface
{
    public function getSupportedTypes(?string $format): array
    {
        return [
            FilterInterface::class => true,
        ];
    }

    /**
     * @throws UndefinedFilterException
     */
    public function denormalize(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = []
    ): ?FilterInterface {
        $filter = match (FilterField::tryFrom($data['field'])) {
            FilterField::NAME => new NameFilter(),
            FilterField::ID => new IdFilter(),
            default => throw new UndefinedFilterException(),
        };

        $filter->setValue($data['value']);

        return $filter;
    }

    public function supportsDenormalization(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = []
    ): bool {
        return $type === FilterInterface::class;
    }
}