<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use D2\Entity\EntityBuilder;
use Exception;
use Tests\Stub\Entity;
use Tests\Stub\EntityAddress;
use Tests\Stub\EntityId;

class EntityBuilderTest extends TestCase
{
    private $params = [
        'id' => 100,
        'primitive_id' => 200,
        'primitive_string' => 'string'
    ];

    public function test_constructor_by_array()
    {
        $entity = EntityBuilder::byConstructor(Entity::class, $this->params);

        $this->instance_asserts($entity, $this->params);
    }

    public function test_constructor_by_object()
    {
        $entity = EntityBuilder::byConstructor(Entity::class, (object) $this->params);

        $this->instance_asserts($entity, $this->params);
    }

    public function test_static_constructor_by_array()
    {
        $entity = EntityBuilder::byStaticConstructor(Entity::class, 'create', $this->params);

        $this->instance_asserts($entity, $this->params);
    }

    public function test_static_constructor_by_object()
    {
        $entity = EntityBuilder::byStaticConstructor(Entity::class, 'create', (object) $this->params);

        $this->instance_asserts($entity, $this->params);
    }

    private function instance_asserts(Entity $instance, $params)
    {
        $id = EntityId::fromPrimitive($params['id']);

        $this->assertNotEmpty($instance->id());
        $this->assertInstanceOf(EntityId::class, $instance->id());
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
        $id = EntityId::fromPrimitive(100);

        $entity = EntityBuilder::byConstructor(Entity::class, [
            'id' => $id,
            'primitive_id' => 200,
            'primitive_string' => 'string'
        ]);

        $this->assertInstanceOf(EntityId::class, $entity->id());
        $this->assertTrue($entity->id()->equalsTo($id));
    }

    public function test_constructor_prefix()
    {
        $params = [
            'address_city'   => 'Moscow',
            'address_street' => 'Krasnaya',
        ];

        $address = EntityBuilder::byConstructor(EntityAddress::class, $params, 'address');

        $this->assertInstanceOf(EntityAddress::class, $address);
        $this->assertEquals($params['address_city'], $address->city());
        $this->assertEquals($params['address_street'], $address->street());
    }

    public function test_missing_primitive_param_exception()
    {
        $this->expectException(Exception::class);

        $params = [
            'id' => 100,
            'primitive_id___' => 200,
            'primitive_string' => 'string'
        ];

        EntityBuilder::byConstructor(Entity::class, $params);
    }

    public function test_missing_value_object_param_exception()
    {
        $this->expectException(Exception::class);

        $params = [
            'id___' => 100,
            'primitive_id' => 200,
            'primitive_string' => 'string'
        ];

        EntityBuilder::byConstructor(Entity::class, $params);
    }
}
