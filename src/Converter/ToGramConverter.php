<?php

declare(strict_types=1);

namespace App\Converter;

class ToGramConverter implements ConverterInterface
{
    public function convert(int $value): int
    {
        return $value * 1000;
    }
}