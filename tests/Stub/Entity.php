<?php

namespace Tests\Stub;

use Tests\Stub\EntityId;
use Tests\Stub\EntityAddress;

class Entity
{
    private EntityId       $id;
    private int           $primitive_id;
    private string        $primitive_string;
    private ?int          $nullable_primitive_id;
    private ?EntityAddress $nullable_address;

    public function __construct(
        EntityId       $id,
        int           $primitive_id,
        string        $primitive_string,
        ?int          $nullable_primitive_id = null,
        ?EntityAddress $nullable_address = null
    ) {
        $this->id                    = $id;
        $this->primitive_id          = $primitive_id;
        $this->primitive_string      = $primitive_string;
        $this->nullable_primitive_id = $nullable_primitive_id;
        $this->nullable_address      = $nullable_address;
    }

    public static function create(
        int    $id,
        int    $primitive_id,
        string $primitive_string
    ): self {
        return new self(
            EntityId::fromPrimitive($id),
            $primitive_id,
            $primitive_string
        );
    }

    public function id(): EntityId
    {
        return $this->id;
    }

    public function primitiveId(): int
    {
        return $this->primitive_id;
    }

    public function primitiveString(): string
    {
        return $this->primitive_string;
    }

    public function nullablePrimitiveId(): ?int
    {
        return $this->nullable_primitive_id;
    }

    public function nullableAddress(): ?EntityAddress
    {
        return $this->nullable_address;
    }
}
