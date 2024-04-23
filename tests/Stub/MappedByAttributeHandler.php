<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub;

use Sco\MessageBus\Handler;
use Sco\MessageBus\Message;

/**
 * @implements Handler<MappedByAttributeCommand|MappedByAttributeQuery, string>
 */
final class MappedByAttributeHandler implements Handler
{
    /**
     * @param MappedByAttributeCommand|MappedByAttributeQuery $message
     */
    public function __invoke(Message $message): string
    {
        return $message->value;
    }
}
