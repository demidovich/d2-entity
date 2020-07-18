<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use D2\Instance;
use Tests\Stub\Model;
use Tests\Stub\ModelId;

class InstanceTest extends TestCase
{
    public function test_constructor()
    {
        $params = [
            'id' => 100,
            'primitive_id' => 200,
            'primitive_string' => 'string'
        ];

        $instance = Instance::byConstructor(Model::class, $params);

        $this->instance_asserts($instance, $params);
    }

    public function test_static_constructor()
    {
        $params = [
            'id' => 100,
            'primitive_id' => 200,
            'primitive_string' => 'string'
        ];

        $instance = Instance::byStaticConstructor(Model::class, 'create', $params);

        $this->instance_asserts($instance, $params);
    }

    private function instance_asserts(Model $instance, array $params)
    {
        $id = ModelId::fromPrimitive($params['id']);

        $this->assertNotEmpty($instance->id());
        $this->assertInstanceOf(ModelId::class, $instance->id());
        $this->assertTrue($instance->id()->equalsTo($id));

        $primitiveId = $params['primitive_id'];

        $this->assertNotEmpty($instance->primitiveId());
        $this->assertEquals($primitiveId, $instance->primitiveId());

        $primitiveString = $params['primitive_string'];

        $this->assertNotEmpty($instance->primitiveString());
        $this->assertEquals('string', $primitiveString);

        $this->assertNull($instance->nullablePrimitiveId());

        $this->assertNull($instance->nullableAddress());
    }
}
