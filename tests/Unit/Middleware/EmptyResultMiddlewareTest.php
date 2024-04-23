<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Unit\Middleware;

use PHPUnit\Framework\Attributes\Test;
use Sco\MessageBus\Bus;
use Sco\MessageBus\Exception\InvalidResult;
use Sco\MessageBus\Middleware\Enforce\EmptyResultMiddleware;
use Sco\MessageBus\Tests\Stub\FooCommand;
use Sco\MessageBus\Tests\Stub\MappedByAttributeCommand;
use Sco\MessageBus\Tests\TestCase;

class EmptyResultMiddlewareTest extends TestCase
{
    #[Test]
    public function it_throws_an_error_when_extending_abstract_command_and_returning_value(): void
    {
        $this->expectException(InvalidResult::class);
        $this->expectExceptionMessage('Commands cannot return values other than null. Sco\MessageBus\Tests\Stub\FooCommand returns object.');

        $fixture = new Bus($this->container, [new EmptyResultMiddleware()]);

        $fixture->dispatch(new FooCommand());
    }

    #[Test]
    public function it_throws_an_error_when_having_command_attribute_and_returning_value(): void
    {
        $this->expectException(InvalidResult::class);
        $this->expectExceptionMessage('Commands cannot return values other than null. Sco\MessageBus\Tests\Stub\MappedByAttributeCommand returns string.');

        $fixture = new Bus($this->container, [new EmptyResultMiddleware()]);

        $fixture->dispatch(new MappedByAttributeCommand());
    }

    #[Test]
    public function it_does_not_throw_an_error_when_an_excluded_command_returns(): void
    {
        EmptyResultMiddleware::$exclude = [MappedByAttributeCommand::class];

        $fixture = new Bus($this->container, [new EmptyResultMiddleware()]);

        $result = $fixture->dispatch(new MappedByAttributeCommand());

        $this->assertSame('Command is mapped by attribute', $result);
    }
}
