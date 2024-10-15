<?php

declare(strict_types=1);

namespace App\Converter;

class ToKilogramConverter implements ConverterInterface
{
    public function convert(int $value): int
    {
        return (int)($value / 1000);
    }
}