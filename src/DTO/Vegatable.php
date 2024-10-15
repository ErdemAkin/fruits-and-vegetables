<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enum\ProduceType;

final class Vegatable extends AbstractProduce
{
    public function __construct()
    {
        $this->type = ProduceType::VEGETABLE;
    }
}