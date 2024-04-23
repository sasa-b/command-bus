<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Unit\Mapper\Strategy;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Sco\MessageBus\Mapper\Strategy\MapByName;
use Sco\MessageBus\Message;
use Sco\MessageBus\Tests\Stub\EchoCommand;
use Sco\MessageBus\Tests\Stub\EchoHandler;
use Sco\MessageBus\Tests\Stub\FooCommand;
use Sco\MessageBus\Tests\Stub\FooHandler;
use Sco\MessageBus\Tests\Stub\FooQuery;
use Sco\MessageBus\Tests\TestCase;

class MapByNameTest extends TestCase
{
    private MapByName $fixture;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixture = new MapByName();
    }

    #[Test]
    #[DataProvider('provideTestData')]
    public function it_can_map_handler_by_attribute(Message $message, string $expectedHandler): void
    {
        $this->assertSame($expectedHandler, $this->fixture->getHandler($message));
    }

    public static function provideTestData(): iterable
    {
        yield [new EchoCommand(''), EchoHandler::class];
        yield [new FooCommand(), FooHandler::class];
        yield [new FooQuery(), FooHandler::class];
    }
}
