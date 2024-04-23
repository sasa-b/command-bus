<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub;

use Sco\MessageBus\Message;

final class FailingCommand implements Message
{
    public function __construct(
        public string $message,
    ) {}
}
