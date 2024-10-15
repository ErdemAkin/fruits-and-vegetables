<?php

declare(strict_types=1);

namespace App\DTO\Filter;

use App\Enum\FilterField;

interface FilterInterface
{
    public function getField(): FilterField;

    public function getValue(): string|int;
}