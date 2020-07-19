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

    public function city(): string
    {
        return $this->city;
    }

    public function street(): string
    {
        return $this->street;
    }
}