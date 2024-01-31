<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Unit\Mapper\Strategy;

use Sco\MessageBus\Mapper\Strategy\MapByName;
use Sco\MessageBus\Message;
use Sco\MessageBus\Tests\Stub\EchoTestCommand;
use Sco\MessageBus\Tests\Stub\EchoTestHandler;
use Sco\MessageBus\Tests\Stub\MixedContentTestCommand;
use Sco\MessageBus\Tests\Stub\MixedContentTestHandler;
use Sco\MessageBus\Tests\TestCase;

class MapByNameTest extends TestCase
{
    private MapByName $fixture;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixture = new MapByName();
    }

    /**
     * @dataProvider  provideTestData
     */
    public function test_it_can_map_handler_by_attribute(Message $message, string $expectedHandler): void
    {
        $this->assertSame($expectedHandler, $this->fixture->getHandler($message));
    }

    public function provideTestData(): iterable
    {
        yield [new EchoTestCommand(''), EchoTestHandler::class];
        yield [new MixedContentTestCommand(), MixedContentTestHandler::class];
    }
}
