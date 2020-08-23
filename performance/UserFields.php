<?php

namespace Performance;

class UserFields
{
    private string $field0;
    private string $field1;
    private string $field2;
    private string $field3;
    private string $field4;
    private string $field5;

    public function __construct(
        string $field0,
        string $field1,
        string $field2,
        string $field3,
        string $field4,
        string $field5
    ) {
        $this->field0 = $field0;
        $this->field1 = $field1;
        $this->field2 = $field2;
        $this->field3 = $field3;
        $this->field4 = $field4;
        $this->field5 = $field5;
    }
}