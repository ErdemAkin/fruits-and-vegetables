<?php

declare(strict_types=1);

namespace App\DTO\Filter;

use App\Enum\FilterField;
use Symfony\Component\Validator\Constraints as Assert;

final class NameFilter extends AbstractFilter
{
    #[Assert\NotBlank]
    private string $value;

    public function __construct()
    {
        $this->field = FilterField::NAME;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}