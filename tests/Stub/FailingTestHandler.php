<?php

declare(strict_types=1);

namespace SasaB\MessageBus\Tests\Stub;

use SasaB\MessageBus\Handler;
use SasaB\MessageBus\Message;

/**
 * @implements Handler<FailingTestCommand>
 */
final class FailingTestHandler implements Handler
{
    public function __invoke(Message $message): mixed
    {
        throw new \RuntimeException('Command Fails');
    }
}
