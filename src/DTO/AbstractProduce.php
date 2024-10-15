<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enum\FilterField;
use App\Enum\ProduceType;
use App\Enum\Unit;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractProduce implements ProduceInterface
{
    #[Assert\NotBlank]
    #[Assert\GreaterThan(0)]
    protected int $id;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    protected string $name;

    #[Assert\NotBlank]
    #[Assert\GreaterThan(0)]
    protected int $quantity;

    #[Assert\NotBlank]
    protected Unit $unit;

    #[Assert\NotBlank]
    protected ProduceType $type;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getUnit(): Unit
    {
        return $this->unit;
    }

    public function setUnit(Unit $unit): void
    {
        $this->unit = $unit;
    }

    public function getType(): ProduceType
    {
        return $this->type;
    }

    public function get(FilterField $field): string|int|null
    {
        return match ($field) {
            FilterField::NAME => $this->name,
            FilterField::ID => $this->id,
            default => null,
        };
    }
}