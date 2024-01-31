<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub;

use Sco\MessageBus\Handler;
use Sco\MessageBus\Message;

final class AttributeTestHandler implements Handler
{
    public function __invoke(Message $message): mixed
    {
        return $message->payload();
    }
}
