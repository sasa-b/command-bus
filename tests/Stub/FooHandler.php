<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub;

use Sco\MessageBus\Handler;
use Sco\MessageBus\Message;

/**
 * @implements Handler<FooCommand>
 */
class FooHandler implements Handler
{
    public function __invoke(Message $message): FooResponse
    {
        return new FooResponse($message->value . ' Handled');
    }
}
