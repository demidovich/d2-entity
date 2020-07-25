<?php

namespace D2\Entity;

use D2\Entity\EntityBuilder\Params;

class EntityBuilder
{
    /**
     * Create object by constructor
     * 
     * @param type $class
     * @param midex $data Array or object
     * @param string $prefix Data fields prefix
     * @return mixed
     */
    public static function byConstructor(string $class, $data, ?string $prefix = null)
    {
        if (! is_array($data)) {
            $data = (array) $data;
        }

        $params = (new Params($class, '__construct'))->casted($data, $prefix);

        return new $class(...$params);
    }

   /**
    * Create object by static constructor
    * 
    * @param type $class
    * @param type $method
    * @param mixed $data Array or object
    * @param string $prefix Data fields prefix
    * @return mixed
    */
    public static function byStaticConstructor(string $class, string $method, $data, ?string $prefix = null)
    {
        if (! is_array($data)) {
            $data = (array) $data;
        }

        $params = (new Params($class, $method))->casted($data, $prefix);

        return $class::$method(...$params);
    }
}
