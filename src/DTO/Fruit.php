<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enum\ProduceType;

final class Fruit extends AbstractProduce
{
    public function __construct()
    {
        $this->type = ProduceType::FRUIT;
    }
}