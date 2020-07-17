<?php

namespace Tests\Stub;

class ModelAddress
{
    private $city;
    private $street;

    public function __construct(string $city, string $street)
    {
        $this->city   = $city;
        $this->street = $street;
    }
}