<?php

namespace Performance;

use RuntimeException;

class UserId
{
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }
}