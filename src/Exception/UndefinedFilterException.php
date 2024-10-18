<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

class UndefinedFilterException extends Exception implements ProduceExceptionInterface
{
    public function __construct()
    {
        parent::__construct('This filter is not defined.');
    }
}