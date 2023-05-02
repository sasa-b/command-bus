<?php

declare(strict_types=1);

namespace SasaB\MessageBus\Tests\Unit;

use PHPUnit\Framework\TestCase;
use SasaB\MessageBus\Result;
use SasaB\MessageBus\Result\ResultMapper;

class ResultMapperTest extends TestCase
{
    private ResultMapper $typeMapper;

    protected function setUp(): void
    {
        parent::setUp();

        $this->typeMapper = new ResultMapper();
    }

    /**
     * @dataProvider providesDataTypes
     */
    public function test_it_can_map_type_to_result(mixed $data, Result $result): void
    {
        $this->assertEquals($this->typeMapper->map($data), $result);
        $this->assertSame($data, $result->payload());
    }

    public function providesDataTypes(): iterable
    {
        yield 'Integer' => [1, new Result\Integer(value: 1)];
        yield 'Double' => [2.02, new Result\Numeric(value: 2.02)];
        yield 'String' => ['xxx-xxx', new Result\Text(value: 'xxx-xxx')];
        yield 'Object' => [$object = new \stdClass(), new Result\Delegated(value: $object)];
        yield 'Map' => [$map = ['foo' => 'bar'], new Result\Map(value: $map)];
        yield 'Empty Map' => [$map = [], new Result\Collection(value: $map)];
        yield 'Collection' => [$collection = ['foo', 'bar'], new Result\Collection(value: $collection)];
        yield 'Empty Collection' => [$collection = [], new Result\Collection(value: $collection)];
        yield 'Null' => [null, new Result\None()];
        yield 'Boolean' => [true, new Result\Boolean(value: true)];
    }
}
