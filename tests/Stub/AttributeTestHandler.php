<?php

declare(strict_types=1);

namespace SasaB\MessageBus\Tests\Stub;

use SasaB\MessageBus\Handler;
use SasaB\MessageBus\Message;

final class AttributeTestHandler implements Handler
{
    public function __invoke(Message $message): mixed
    {
        return $message->payload();
    }
}
