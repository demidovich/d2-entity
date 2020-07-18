<?php

namespace D2\Instance;

use ReflectionMethod;
use ReflectionParameter;
use RuntimeException;

class Params
{
    private $class;
    private $method;

    public function __construct(string $class, string $method)
    {
        $this->class  = $class;
        $this->method = $method;
    }

    /**
     * Build params
     *
     * @param ReflectionParameter[] $reflectionParams
     * @param array $data
     * @return array
     */
    public function casted(array $data): array
    {
        $params = [];
        $reflection = (new ReflectionMethod($this->class, $this->method))->getParameters();

        foreach ($reflection as $param) {

            $name = $param->getName();

            if ($param->getClass()) {
                $value = $this->valueObject($data, $param, $param->getClass()->name);
            }

            elseif (array_key_exists($name, $data)) {
                $value = $data[$name];
            }

            else {
                if ($param->isOptional()) {
                    $value = $param->getDefaultValue();
                } else {
                    $this->exception(
                        "Параметр \"{$name}\" не имеет значения по-умолчанию и отсутствует во входных данных"
                    );
                }
            }

            $params[] = $value;
        }

        return $params;
    }

    private function valueObject(array $data, ReflectionParameter $reflection, string $voClass)
    {
        $param = $reflection->getName();

        if (isset($data[$param])) {

            $value = $data[$param];

            if (! is_object($value)) {
                return new $voClass($value);
            }

            $actualClass = get_class($value);

            if ($voClass === $actualClass) {
                return $value;
            }

            $this->exception(
                "Для объекта-значения {$voClass} {$param} передан некорректный объект {$actualClass}"
            );
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