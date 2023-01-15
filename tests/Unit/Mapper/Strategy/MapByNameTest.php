<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Tests\Unit\Mapper\Strategy;

use SasaB\CommandBus\Mapper\Strategy\MapByName;
use SasaB\CommandBus\Message;
use SasaB\CommandBus\Tests\Stub\EchoTestHandler;
use SasaB\CommandBus\Tests\Stub\EchoTestMessage;
use SasaB\CommandBus\Tests\Stub\MixedContentTestHandler;
use SasaB\CommandBus\Tests\Stub\MixedContentTestMessage;
use SasaB\CommandBus\Tests\TestCase;

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
        yield [new EchoTestMessage(''), EchoTestHandler::class];
        yield [new MixedContentTestMessage(), MixedContentTestHandler::class];
    }
}
