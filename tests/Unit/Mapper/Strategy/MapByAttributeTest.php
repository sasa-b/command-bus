<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Unit\Mapper\Strategy;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Sco\MessageBus\Mapper\Strategy\MapByAttribute;
use Sco\MessageBus\Message;
use Sco\MessageBus\Tests\Stub\MappedByAttributeCommand;
use Sco\MessageBus\Tests\Stub\MappedByAttributeHandler;
use Sco\MessageBus\Tests\Stub\MappedByAttributeQuery;
use Sco\MessageBus\Tests\TestCase;

class MapByAttributeTest extends TestCase
{
    private MapByAttribute $fixture;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixture = new MapByAttribute();
    }

    #[Test]
    #[DataProvider('provideTestData')]
    public function it_can_map_handler_by_attribute(Message $message): void
    {
        $this->assertSame(MappedByAttributeHandler::class, $this->fixture->getHandler($message));
    }

    public static function provideTestData(): iterable
    {
        yield [new MappedByAttributeCommand()];
        yield [new MappedByAttributeQuery()];
    }
}
