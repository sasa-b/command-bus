<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Unit\Middleware;

use Sco\MessageBus\Bus;
use Sco\MessageBus\Exception\InvalidResult;
use Sco\MessageBus\Middleware\Enforce\EmptyResultMiddleware;
use Sco\MessageBus\Tests\Stub\AttributeTestCommand;
use Sco\MessageBus\Tests\Stub\MixedContentTestCommand;
use Sco\MessageBus\Tests\Stub\TestItemObject;
use Sco\MessageBus\Tests\TestCase;

class EmptyResultMiddlewareTest extends TestCase
{
    public function test_it_throws_an_error_when_extending_abstract_command_and_returning_value(): void
    {
        $this->expectException(InvalidResult::class);
        $this->expectExceptionMessage('Commands cannot return values other than null. Sco\MessageBus\Tests\Stub\MixedContentTestCommand returns object.');

        $fixture = new Bus($this->container, [new EmptyResultMiddleware()]);

        $fixture->dispatch(new MixedContentTestCommand(new TestItemObject()));
    }

    public function test_it_throws_an_error_when_having_command_attribute_and_returning_value(): void
    {
        $this->expectException(InvalidResult::class);
        $this->expectExceptionMessage('Commands cannot return values other than null. Sco\MessageBus\Tests\Stub\AttributeTestCommand returns string.');

        $fixture = new Bus($this->container, [new EmptyResultMiddleware()]);

        $fixture->dispatch(new AttributeTestCommand());
    }
}
