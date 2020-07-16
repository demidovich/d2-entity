<?php

namespace Tests\Stub;

use Tests\Stub\ModelId;

class Model
{
    private ModelId $id;
    private int $primitiveId;
    private string $primitiveString;
    private ?int $nullablePrimitiveInt;
    private ?Address $address

    public function __construct(
        ModelId $id,
        int $primitiveId,
        string $primitiveString,
        ?int $nullablePrimitiveInt = null,
        ?Address $address = null
    ) {
        $this->id = $id;
        $this->intprimitiveId = $primitiveId;
        $this->primitiveString = $primitiveString;
        $this->nullablePrimitiveInt = $nullablePrimitiveInt;
        $this->address = $address;
    }

    public function __get($name)
    {
        return $this->$name;
    }
}
