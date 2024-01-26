<?php

declare(strict_types=1);

namespace SasaB\MessageBus\Tests\Unit\Middleware;

use SasaB\MessageBus\Bus;
use SasaB\MessageBus\Exception\InvalidResult;
use SasaB\MessageBus\Middleware\Enforce\EmptyResultMiddleware;
use SasaB\MessageBus\Tests\Stub\AttributeTestCommand;
use SasaB\MessageBus\Tests\Stub\MixedContentTestCommand;
use SasaB\MessageBus\Tests\Stub\TestItemObject;
use SasaB\MessageBus\Tests\TestCase;

class EmptyResultMiddlewareTest extends TestCase
{
    public function test_it_throws_an_error_when_extending_abstract_command_and_returning_value(): void
    {
        $this->expectException(InvalidResult::class);
        $this->expectExceptionMessage('Commands cannot return values other than null. SasaB\MessageBus\Tests\Stub\MixedContentTestCommand returns object.');

        $fixture = new Bus($this->container, [new EmptyResultMiddleware()]);

        $fixture->dispatch(new MixedContentTestCommand(new TestItemObject()));
    }

    public function test_it_throws_an_error_when_having_command_attribute_and_returning_value(): void
    {
        $this->expectException(InvalidResult::class);
        $this->expectExceptionMessage('Commands cannot return values other than null. SasaB\MessageBus\Tests\Stub\AttributeTestCommand returns string.');

        $fixture = new Bus($this->container, [new EmptyResultMiddleware()]);

        $fixture->dispatch(new AttributeTestCommand());
    }
}
