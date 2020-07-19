<?php

namespace Performance;

use RuntimeException;

class UserName
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }
}