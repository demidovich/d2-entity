<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use D2\ModelBuilder;
use Tests\Stub\Model;
use Tests\Stub\ModelAddress;
use Tests\Stub\ModelId;

class ModelBuilderTest extends TestCase
{
    public function test_constructor()
    {
        $params = [
            'id' => 100,
            'primitive_id' => 200,
            'primitive_string' => 'string'
        ];

        $model = ModelBuilder::byConstructor(Model::class, $params);

        $this->instance_asserts($model, $params);
    }

    public function test_static_constructor()
    {
        $params = [
            'id' => 100,
            'primitive_id' => 200,
            'primitive_string' => 'string'
        ];

        $model = ModelBuilder::byStaticConstructor(Model::class, 'create', $params);

        $this->instance_asserts($model, $params);
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

    public function test_constructor_value_object()
    {
        $id = ModelId::fromPrimitive(100);

        $model = ModelBuilder::byConstructor(Model::class, [
            'id' => $id,
            'primitive_id' => 200,
            'primitive_string' => 'string'
        ]);

        $this->assertInstanceOf(ModelId::class, $model->id());
        $this->assertTrue($model->id()->equalsTo($id));
    }

    public function test_constructor_prefix()
    {
        $params = [
            'address_city'   => 'Moscow',
            'address_street' => 'Krasnaya',
        ];

        $address = ModelBuilder::byConstructor(ModelAddress::class, $params, 'address_');

        $this->assertInstanceOf(ModelAddress::class, $address);
        $this->assertEquals($params['address_city'], $address->city());
        $this->assertEquals($params['address_street'], $address->street());
    }
}
