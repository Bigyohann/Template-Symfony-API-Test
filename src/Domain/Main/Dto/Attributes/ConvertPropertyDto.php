<?php

namespace App\Domain\Main\Dto\Attributes;

use Attribute;

#[Attribute]
class ConvertPropertyDto
{
    public function __construct(public bool $shouldConvertAutomatically = true)
    {
    }
}