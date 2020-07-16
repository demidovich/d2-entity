<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Blues\Hydrator;
use Tests\Stub\Model;
use Tests\Stub\ModelId;

class HydratorTest extends TestCase
{
    public function test_constructor()
    {
        $m = Hydrator::byConstructor(Model::class, []);

        
    }
}
