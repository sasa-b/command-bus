<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub;

use Sco\MessageBus\Command;

class FooCommand extends Command
{
    public function __construct(
        public readonly string $value = 'FooCommand',
    ) {}
}
