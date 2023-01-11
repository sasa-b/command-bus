<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Tests\Unit\Mapper\Strategy;

use SasaB\CommandBus\Command;
use SasaB\CommandBus\Mapper\Strategy\MapByName;
use SasaB\CommandBus\Tests\Stub\EchoTestCommand;
use SasaB\CommandBus\Tests\Stub\EchoTestHandler;
use SasaB\CommandBus\Tests\Stub\MixedContentTestCommand;
use SasaB\CommandBus\Tests\Stub\MixedContentTestHandler;
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
    public function test_it_can_map_handler_by_attribute(Command $command, string $expectedHandler): void
    {
        $this->assertSame($expectedHandler, $this->fixture->getHandler($command));
    }

    public function provideTestData(): iterable
    {
        yield [new EchoTestCommand(''), EchoTestHandler::class];
        yield [new MixedContentTestCommand(), MixedContentTestHandler::class];
    }
}
