<?php

declare(strict_types=1);

namespace App\Enum;

enum FilterField: string
{
    case ID = 'id';

    case NAME = 'name';
}