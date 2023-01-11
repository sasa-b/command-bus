<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Tests\Unit\Mapper\Strategy;

use SasaB\CommandBus\Command;
use SasaB\CommandBus\Mapper\Strategy\MapByAttribute;
use SasaB\CommandBus\Tests\Stub\AttributeCommand;
use SasaB\CommandBus\Tests\Stub\AttributeHandler;
use SasaB\CommandBus\Tests\TestCase;

class MapByAttributeTest extends TestCase
{
    private MapByAttribute $fixture;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixture = new MapByAttribute();
    }

    /**
     * @dataProvider  provideTestData
     */
    public function test_it_can_map_handler_by_attribute(Command $command): void
    {
        $this->assertSame(AttributeHandler::class, $this->fixture->getHandler($command));
    }

    public function provideTestData(): iterable
    {
        yield ['command' => new AttributeCommand()];
        yield ['query' => new AttributeCommand()];
    }
}
