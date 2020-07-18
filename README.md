[![Build Status](https://travis-ci.com/demidovich/d2-instance.svg?branch=master)](https://travis-ci.com/demidovich/d2-instance) [![codecov](https://codecov.io/gh/demidovich/d2-instance/branch/master/graph/badge.svg)](https://codecov.io/gh/demidovich/d2-instance)

## d2 instance

Creating an instance of an object with the casted parameters.

```
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

$user = Instance::byConstructor(User::class, [
    'id' => 1,
    'name' => 'Ivan',
    'created_at' => '1970-01-01 00:00:00',
]);
```
