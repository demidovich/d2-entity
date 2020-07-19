[![Build Status](https://travis-ci.org/demidovich/d2-model-builder.svg?branch=master)](https://travis-ci.com/demidovich/d2-model-builder) [![codecov](https://codecov.io/gh/demidovich/d2-model-builder/branch/master/graph/badge.svg)](https://codecov.io/gh/demidovich/d2-model-builder)

## d2 instance

Creating an instance of an object with the casted parameters.

```php
class UserId
{
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
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
        DateTimeImmutable $created_at
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->created_at = $created_at;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->created_at;
    }
}

$user = ModelBuilder::byConstructor(User::class, [
    'id' => 1,
    'name' => 'Ivan',
    'created_at' => '1970-01-01 00:00:00',
]);
```
