<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Tests\Stub;

use SasaB\CommandBus\Handler;
use SasaB\CommandBus\Message;

final class AttributeHandler implements Handler
{
    public function __invoke(Message $command): mixed
    {
        return $command->payload();
    }
}
