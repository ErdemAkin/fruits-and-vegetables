<?php

declare(strict_types=1);

namespace App\DTO\Filter;

use App\Enum\FilterField;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractFilter implements FilterInterface
{
    #[Assert\NotBlank]
    protected FilterField $field;


    public function getField(): FilterField
    {
        return $this->field;
    }
}