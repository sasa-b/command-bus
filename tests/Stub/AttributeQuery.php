<?php

declare(strict_types=1);

namespace SasaB\MessageBus\Tests\Stub;

use SasaB\MessageBus\Attribute\IsQuery;
use SasaB\MessageBus\Concern\CanIdentify;

use function Tests\uuid;

#[IsQuery(handler: AttributeHandler::class)]
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
