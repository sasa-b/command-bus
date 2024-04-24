<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub;

use Sco\MessageBus\Attribute\IsQuery;
use Sco\MessageBus\Message;

/**
 * @implements Message<FooResult, FooHandler>
 */
#[IsQuery(handler: FooHandler::class)]
final readonly class FooMessage implements Message
{
    public function __construct(
        public string $value = 'FooMessage',
    ) {}
}
