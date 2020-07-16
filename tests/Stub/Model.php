<?php

namespace Tests\Stub;

use Tests\Stub\ModelId;

class Model
{
    private ModelId $id;
    private int $int;
    private string $string;
    private ?int $nullableInt = null;

    public function __get($name)
    {
        return $this->$name;
    }
}
