<?php

namespace D2\Instance;

use ReflectionMethod;

class ParamsCache
{
    private static $cache;

    public static function params(string $class, string $method): array
    {
        if (! isset(self::$cache[$class][$method])) {
            self::init($class, $method);
        }

        return self::$cache[$class][$method];
    }

    private static function init(string $class, string $method): void
    {
        self::$cache[$class][$method] = [];
        $cache =& self::$cache[$class][$method];

        foreach ((new ReflectionMethod($class, $method))->getParameters() as $param) {
            $cache[$param->getName()] = [
                'type'  => $param->getType()->isBuiltin() ? $param->getType()->getName() : null,
                'class' => $param->getClass() ? $param->getClass()->getName() : null,
            ];
            if ($param->isOptional()) {
                $cache[$param->getName()]['default'] = $param->getDefaultValue();
            }
        }
    }
}