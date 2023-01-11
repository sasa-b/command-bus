<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Tests\Stub;

use SasaB\CommandBus\Attribute\IsQuery;
use SasaB\CommandBus\Command;
use SasaB\CommandBus\Response\Concerns\CanIdentify;

use function Tests\uuid;

#[IsQuery(handledBy: AttributeHandler::class)]
final class AttributeCommand implements Command
{
    use CanIdentify;

    public function __construct()
    {
        $this->setUuid(uuid());
    }

    public function payload(): string
    {
        return 'Command is mapped by attribute';
    }
}
