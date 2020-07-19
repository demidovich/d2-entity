<?php

namespace D2\Instance;

use ReflectionMethod;
use ReflectionParameter;
use RuntimeException;

class Params2
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
     * @param string $prefix Data fields prefix
     * @return array
     */
    public function casted(array $data, ?string $prefix = null): array
    {
        $casted = [];
        $params = ParamsCache::params($this->class, $this->method);

        foreach ($params as $param => $v) {

            $param   = "{$prefix}{$param}";
            $type    = $v['type'];
            $voClass = $v['class'];

            if (array_key_exists($param, $data)) {
                $value = $data[$param];
                if ($voClass && ! is_object($value)) {
                    $value = new $voClass($value);
                }
            }

            elseif (array_key_exists('default', $v)) {
                $value = $v['default'];
            }

            else {
                $this->exception(
                    "Параметр \"{$param}\" не имеет значения по-умолчанию и отсутствует во входных данных"
                );
            }

            $casted[] = $value;
        }

        return $casted;
    }

    private function exception(string $message): void
    {
        throw new RuntimeException(
            "Ошибка гидрации {$this->class}::{$this->method}(). {$message}"
        );
    }
}