<?php

declare(strict_types=1);

namespace App\Enum;

enum ProduceType: string
{
    case FRUIT = 'fruit';

    case VEGETABLE = 'vegetable';
}