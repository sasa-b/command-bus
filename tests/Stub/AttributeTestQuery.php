<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub;

use Sco\MessageBus\Attribute\IsQuery;
use Sco\MessageBus\Concern\CanIdentify;

use function Tests\uuid;

#[IsQuery(handler: AttributeTestHandler::class)]
final class AttributeTestQuery
{
    use CanIdentify;

    public function __construct()
    {
        $this->setId(uuid());
    }

    public function payload(): string
    {
        return 'Query is mapped by attribute';
    }
}
