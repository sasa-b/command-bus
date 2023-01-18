<?php

declare(strict_types=1);

namespace SasaB\MessageBus\Tests\Stub;

use SasaB\MessageBus\Concern\CanIdentify;
use SasaB\MessageBus\Message;

use function Tests\uuid;

final class FailingTestCommand implements Message
{
    use CanIdentify;

    public function __construct(public string $message)
    {
        $this->setUuid(uuid());
    }

    public function payload(): string
    {
        return $this->message;
    }
}
