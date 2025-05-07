<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub;

use Sco\MessageBus\Handler;
use Sco\MessageBus\Message;

/**
 * @implements Handler<FailingCommand,void>
 */
final class FailingHandler implements Handler
{
    public function __invoke(Message $message): mixed
    {
        throw new \RuntimeException('Command Fails');
    }
}
