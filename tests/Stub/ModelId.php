<?php

namespace Tests\Stub;

class ModelId
{
    private int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public static function fromPrimitive(int $value): self
    {
        return new self($value);
    }

    public function equalsTo(self $other): bool
    {
        return $this->value === $other->value;
    }
}