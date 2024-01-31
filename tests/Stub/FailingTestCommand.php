<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub;

use Sco\MessageBus\Concern\CanIdentify;
use Sco\MessageBus\Message;

use function Tests\uuid;

final class FailingTestCommand implements Message
{
    use CanIdentify;

    public function __construct(public string $message)
    {
        $this->setId(uuid());
    }

    public function payload(): string
    {
        return $this->message;
    }
}
