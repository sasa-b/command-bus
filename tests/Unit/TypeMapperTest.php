<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Tests\Unit;

use PHPUnit\Framework\TestCase;
use SasaB\CommandBus\Response;
use SasaB\CommandBus\Response\TypeMapper;

class TypeMapperTest extends TestCase
{
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
        $this->assertSame($data, $response->content());
    }

    public function providesDataTypes(): iterable
    {
        yield 'Integer' => [1, new Response\Integer(content: 1)];
        yield 'Double' => [2.02, new Response\Double(content: 2.02)];
        yield 'String' => ['xxx-xxx', new Response\Text(content: 'xxx-xxx')];
        yield 'Object' => [$object = new \stdClass(), new Response\Delegated(content: $object)];
    }
}
