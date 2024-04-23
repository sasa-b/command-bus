<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub;

use Sco\MessageBus\Query;

class FooQuery extends Query
{
    public function __construct(
        public readonly string $value = 'FooQuery',
    ) {}
}
