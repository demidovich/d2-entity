<?php

namespace Performance;

class UserAddress
{
    private $country;
    private $city;
    private $street;
    private $house;
    private $flat;
    private $zip_code;

    public function __construct(
        string  $country,
        string  $city,
        string  $street,
        string  $house,
        ?string $flat,
        int     $zip_code
    ) {
        $this->country = $country;
        $this->city = $city;
        $this->street = $street;
        $this->house = $house;
        $this->flat = $flat;
        $this->zip_code = $zip_code;
    }
}