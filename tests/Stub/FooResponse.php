<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub;

use Sco\MessageBus\Concern\CanIdentify;
use Sco\MessageBus\HasIdentity;

final class FooResponse implements HasIdentity
{
    use CanIdentify;

    public function __construct(
        public readonly string $value = 'FooResponse',
    ) {}
}
