<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Tests\Unit;

use PHPUnit\Framework\TestCase;
use SasaB\CommandBus\Response;
use SasaB\CommandBus\Response\TypeMapper;

class TypeMapperTest extends TestCase
{
    private TypeMapper $typeMapper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->typeMapper = new TypeMapper();
    }

    /**
     * @dataProvider providesDataTypes
     */
    public function test_it_can_map_type_to_response(mixed $data, Response $response): void
    {
        $this->assertEquals($this->typeMapper->map($data), $response);
    }

    public function providesDataTypes(): iterable
    {
        yield 'Integer' => [1, new Response\Integer(value: 1)];
        yield 'Double' => [2.02, new Response\Numeric(value: 2.02)];
        yield 'String' => ['xxx-xxx', new Response\Text(value: 'xxx-xxx')];
        yield 'Object' => [$object = new \stdClass(), new Response\Delegated(value: $object)];
        yield 'Map' => [$map = ['foo' => 'bar'], new Response\Map(value: $map)];
        yield 'Empty Map' => [$map = [], new Response\Collection(value: $map)];
        yield 'Collection' => [$collection = ['foo', 'bar'], new Response\Collection(value: $collection)];
        yield 'Empty Collection' => [$collection = [], new Response\Collection(value: $collection)];
        yield 'Null' => [null, new Response\None()];
        yield 'Boolean' => [true, new Response\Boolean(value: true)];
    }
}
