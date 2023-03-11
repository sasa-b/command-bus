<?php

declare(strict_types=1);

namespace SasaB\MessageBus\Tests\Unit\Middleware;

use SasaB\MessageBus\Bus;
use SasaB\MessageBus\Exception\InvalidResponse;
use SasaB\MessageBus\Middleware\Enforce\EmptyResponseMiddleware;
use SasaB\MessageBus\Tests\Stub\MixedContentTestCommand;
use SasaB\MessageBus\Tests\Stub\TestItemObject;
use SasaB\MessageBus\Tests\TestCase;

class EmptyResponseMiddlewareTest extends TestCase
{
    public function test_it_throws_an_error_when_commands_return_value(): void
    {
        $this->expectException(InvalidResponse::class);
        $this->expectErrorMessage('Commands cannot return values other than null. SasaB\MessageBus\Tests\Stub\MixedContentTestCommand returns object.');

        $fixture = new Bus($this->container, [new EmptyResponseMiddleware()]);

        $fixture->dispatch(new MixedContentTestCommand(new TestItemObject()));
    }
}
