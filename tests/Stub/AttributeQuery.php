<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Tests\Stub;

use SasaB\CommandBus\Attribute\IsQuery;
use SasaB\CommandBus\Response\Concerns\CanIdentify;

use function Tests\uuid;

#[IsQuery(handledBy: AttributeHandler::class)]
final class AttributeQuery
{
    use CanIdentify;

    public function __construct()
    {
        $this->setUuid(uuid());
    }

    public function payload(): string
    {
        return 'Query is mapped by attribute';
    }
}
