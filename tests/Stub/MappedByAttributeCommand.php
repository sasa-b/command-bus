<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub;

use Sco\MessageBus\Attribute\IsCommand;
use Sco\MessageBus\Concern\CanIdentify;
use Sco\MessageBus\Message;

use function Tests\uuid;

#[IsCommand(handler: MappedByAttributeHandler::class)]
final class MappedByAttributeCommand implements Message
{
    use CanIdentify;

    public function __construct(
        public string $value = 'Command is mapped by attribute',
    ) {
        $this->setId(uuid());
    }
}
