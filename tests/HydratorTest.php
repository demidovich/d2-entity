<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Blues\Hydrator;
use ReflectionClass;
use Tests\Stub\Model;
use Tests\Stub\ModelId;

class HydratorTest extends TestCase
{
    // public function test_constructor()
    // {
    //     //$m = Hydrator::byConstructor(Model::class, []);

    //     $r1 = (new \ReflectionClass(Model::class))->getProperties(\ReflectionProperty::IS_PRIVATE);
    //     //$r1 = (new \ReflectionMethod(Model::class, '__construct'))->getParameters();

    //     foreach ($r1 as $property) {


    //         dd(
    //             $property->getName(),
    //             $property->isDefault(),
    //             $property->getType()->isBuiltin(),  // primitive
    //             $property->getType()->getName(),    // type or classname
    //             $property->getType()->allowsNull()
    //         );

    //     }

    //     exit;

    //     dd($r1, $r2);
    // }

    public function test_constructor()
    {
        $i = Hydrator::byConstructor(Model::class, [
            'id' => 100
        ]);

        dd($i);
    }
}
