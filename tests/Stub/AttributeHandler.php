<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Tests\Stub;

use SasaB\CommandBus\Command;
use SasaB\CommandBus\Handler;

final class AttributeHandler implements Handler
{
    public function handle(Command $command): mixed
    {
        return $command->payload();
    }
}
