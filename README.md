[![Build Status](https://travis-ci.com/demidovich/d2-entity-builder.svg?branch=master)](https://travis-ci.com/demidovich/d2-entity-builder) [![codecov](https://codecov.io/gh/demidovich/d2-entity/branch/master/graph/badge.svg)](https://codecov.io/gh/demidovich/d2-entity)

## d2 entity builder

Simple builder of domain entities from primitives and value objects. Builds an entity by calling a __construct() or static constructor.

```php
class UserId
{
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }
}

class UserAddress
{
    private $city;
    private $street;
    private $house;

    public function __construct(string $street, string $city, string $house)
    {
        $this->city = $city;
        $this->street = $street;
        $this->house = $house;
    }
}

class User
{
    private $id;
    private $name;
    private $created_at;

    public function __construct(
        UserId $id,
        string $name,
        UserAddress $address,
        DateTimeImmutable $created_at
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->created_at = $created_at;
    }
}

$dbRow = [
    'id'             => 1,
    'name'           => 'Ivan',
    'created_at'     => '1970-01-01 00:00:00',
    'address_city'   => 'Moscow',
    'address_street' => 'Krasnaya',
    'address_house'  => '1',
];

$dbRow['address'] = EntityBuilder::construct(UserAddress::class, $dbRow, 'address');

$user = EntityBuilder::construct(User::class, $dbRow);
```
