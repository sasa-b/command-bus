<?php

declare(strict_types=1);

namespace SasaB\MessageBus\Tests\Unit\Mapper\Strategy;

use SasaB\MessageBus\Mapper\Strategy\MapByAttribute;
use SasaB\MessageBus\Message;
use SasaB\MessageBus\Tests\Stub\AttributeTestCommand;
use SasaB\MessageBus\Tests\Stub\AttributeTestHandler;
use SasaB\MessageBus\Tests\TestCase;

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
    public function test_it_can_map_handler_by_attribute(Message $message): void
    {
        $this->assertSame(AttributeTestHandler::class, $this->fixture->getHandler($message));
    }

    public function provideTestData(): iterable
    {
        yield ['command' => new AttributeTestCommand()];
        yield ['query' => new AttributeTestCommand()];
    }
}
