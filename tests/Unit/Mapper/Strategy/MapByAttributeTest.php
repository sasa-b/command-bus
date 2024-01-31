<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Unit\Mapper\Strategy;

use Sco\MessageBus\Mapper\Strategy\MapByAttribute;
use Sco\MessageBus\Message;
use Sco\MessageBus\Tests\Stub\AttributeTestCommand;
use Sco\MessageBus\Tests\Stub\AttributeTestHandler;
use Sco\MessageBus\Tests\TestCase;

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
