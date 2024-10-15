<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enum\FilterField;
use App\Enum\ProduceType;
use App\Enum\Unit;

interface ProduceInterface
{
    public function get(FilterField $field): string|int|null;

    public function getId(): int;

    public function setId(int $id): void;

    public function getName(): string;

    public function setName(string $name): void;

    public function getQuantity(): int;

    public function setQuantity(int $quantity): void;

    public function getUnit(): Unit;

    public function setUnit(Unit $unit): void;

    public function getType(): ProduceType;
}