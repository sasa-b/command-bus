<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Tests\Stub;

use SasaB\CommandBus\Attribute\IsQuery;
use SasaB\CommandBus\Command;
use SasaB\CommandBus\Concern\CanIdentify;

use function Tests\uuid;

#[IsQuery(handler: AttributeHandler::class)]
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
