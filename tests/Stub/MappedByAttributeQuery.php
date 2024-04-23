<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub;

use Sco\MessageBus\Attribute\IsQuery;
use Sco\MessageBus\Concern\CanIdentify;

use Sco\MessageBus\Message;

use function Tests\uuid;

#[IsQuery(handler: MappedByAttributeHandler::class)]
final class MappedByAttributeQuery implements Message
{
    use CanIdentify;

    public function __construct(
        public string $value = 'Query is mapped by attribute',
    ) {
        $this->setId(uuid());
    }
}
