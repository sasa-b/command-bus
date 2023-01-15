<?php

declare(strict_types=1);

namespace SasaB\MessageBus\Tests\Unit\Mapper\Strategy;

use SasaB\MessageBus\Mapper\Strategy\MapByName;
use SasaB\MessageBus\Message;
use SasaB\MessageBus\Tests\Stub\EchoTestCommand;
use SasaB\MessageBus\Tests\Stub\EchoTestHandler;
use SasaB\MessageBus\Tests\Stub\MixedContentTestCommand;
use SasaB\MessageBus\Tests\Stub\MixedContentTestHandler;
use SasaB\MessageBus\Tests\TestCase;

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
    public function test_it_can_map_handler_by_attribute(Message $command, string $expectedHandler): void
    {
        $this->assertSame($expectedHandler, $this->fixture->getHandler($command));
    }

    public function provideTestData(): iterable
    {
        yield [new EchoTestCommand(''), EchoTestHandler::class];
        yield [new MixedContentTestCommand(), MixedContentTestHandler::class];
    }
}
