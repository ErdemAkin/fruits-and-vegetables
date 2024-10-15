<?php

declare(strict_types=1);

namespace App\DTO\Filter;

use App\Enum\FilterField;
use Symfony\Component\Validator\Constraints as Assert;

final class IdFilter extends AbstractFilter
{
    #[Assert\NotBlank]
    private int $value;

    public function __construct()
    {
        $this->field = FilterField::ID;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }
}