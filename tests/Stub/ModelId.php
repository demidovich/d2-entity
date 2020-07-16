<?php

namespace Tests\Stub;

class ModelId
{
    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }
}