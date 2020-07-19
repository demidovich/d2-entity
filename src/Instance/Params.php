<?php

namespace D2\Instance;

use ReflectionMethod;
use ReflectionParameter;
use RuntimeException;

class Params
{
    private $class;
    private $method;

    // private static $cache;

    public function __construct(string $class, string $method)
    {
        $this->class  = $class;
        $this->method = $method;
    }

    // protected static function reflectionParamsCached(string $class, string $method): array
    // {
    //     if (! isset(self::$cache[$class][$method])) {
    //         self::$cache[$class][$method] = (new ReflectionMethod($class, $method))->getParameters();
    //         echo 1;
    //     }

    //     return self::$cache[$class][$method];
    // }

    /**
     * Build params
     *
     * @param ReflectionParameter[] $reflectionParams
     * @param array $data
     * @param string $prefix Data fields prefix
     * @return array
     */
    public function casted(array $data, ?string $prefix = null): array
    {
        $casted = [];
        $reflection = (new ReflectionMethod($this->class, $this->method))->getParameters();

        foreach ($reflection as $param) {

            $name = "{$prefix}{$param->getName()}";

            if ($param->getClass()) {
                $value = $this->valueObject($data, $name, $param);
            }

            elseif (array_key_exists($name, $data)) {
                $value = $data[$name];
            }

            elseif ($param->isOptional()) {
                $value = $param->getDefaultValue();      
            }

            else {
                $this->exception(
                    "Параметр \"{$name}\" не имеет значения по-умолчанию и отсутствует во входных данных"
                );
            }

            $casted[] = $value;
        }

        return $casted;
    }

    // private function valueObject(array $data, string $param, ReflectionParameter $reflection)
    // {
    //     $voClass = $reflection->getClass()->name;

    //     if (isset($data[$param])) {

    //         $value = $data[$param];

    //         if (! is_object($value)) {
    //             return new $voClass($value);
    //         }

    //         $actualClass = get_class($value);

    //         if ($voClass === $actualClass) {
    //             return $value;
    //         }

    //         $this->exception(
    //             "Для объекта-значения {$voClass} {$param} передан некорректный объект {$actualClass}"
    //         );
    //     }

    //     if ($reflection->isOptional()) {
    //         return $reflection->getDefaultValue();
    //     }

    //     $this->exception(
    //         "Нет данных для создания объекта-значения {$voClass} {$param}"
    //     );
    // }

    private function valueObject(array $data, string $param, ReflectionParameter $reflection)
    {
        $voClass = $reflection->getClass()->name;

        if (isset($data[$param])) {

            $value = $data[$param];

            if (! is_object($value)) {
                $value = new $voClass($value);
            }

            return $value;
        }

        if ($reflection->isOptional()) {
            return $reflection->getDefaultValue();
        }

        $this->exception(
            "Нет данных для создания объекта-значения {$voClass} {$param}"
        );
    }

    private function exception(string $message): void
    {
        throw new RuntimeException(
            "Ошибка гидрации {$this->class}::{$this->method}(). {$message}"
        );
    }
}