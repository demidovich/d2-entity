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
    private $field0;
    private $field1;
    private $field2;
    private $field3;
    private $field4;
    private $field5;
    private $field6;
    private $field7;
    private $field8;
    private $field9;

    public function __construct(
        UserId $id,
        UserName $name,
        UserEmail $email,
        UserAddress $address,
        UserPreferences $preferences,
        DateTimeImmutable $created_at,
        string $field0,
        string $field1,
        string $field2,
        string $field3,
        string $field4,
        string $field5,
        string $field6 = null,
        string $field7 = null,
        string $field8 = null,
        string $field9 = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->address = $address;
        $this->preferences = $preferences;
        $this->created_at = $created_at;
        $this->field0 = $field0;
        $this->field1 = $field1;
        $this->field2 = $field2;
        $this->field3 = $field3;
        $this->field4 = $field4;
        $this->field5 = $field5;
        $this->field6 = $field6;
        $this->field7 = $field7;
        $this->field8 = $field8;
        $this->field9 = $field9;
    }
}