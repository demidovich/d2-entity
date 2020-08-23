<?php

namespace Performance;

use DateTimeImmutable;

class User
{
    private $id;
    private $name;
    private $email;
    private $address;
    private $preferences;
    private $created_at;
    private $fields;

    public function __construct(
        UserId $id,
        UserName $name,
        UserEmail $email,
        UserAddress $address,
        UserPreferences $preferences,
        DateTimeImmutable $created_at,
        UserFields $fields
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->address = $address;
        $this->preferences = $preferences;
        $this->created_at = $created_at;
        $this->fields = $fields;
    }
}