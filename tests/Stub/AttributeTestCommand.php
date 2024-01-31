<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub;

use Sco\MessageBus\Attribute\IsCommand;
use Sco\MessageBus\Concern\CanIdentify;
use Sco\MessageBus\Message;

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
