<?php

declare(strict_types=1);

namespace SasaB\MessageBus\Tests\Stub;

use SasaB\MessageBus\Attribute\IsCommand;
use SasaB\MessageBus\Concern\CanIdentify;
use SasaB\MessageBus\Message;

use function Tests\uuid;

#[IsCommand(handler: AttributeTestHandler::class)]
final class AttributeTestCommand implements Message
{
    use CanIdentify;

    public function __construct()
    {
        $this->setId(uuid());
    }

    public function payload(): string
    {
        return 'Command is mapped by attribute';
    }
}
