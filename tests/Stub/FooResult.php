<?php

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub;

use Sco\MessageBus\Result;

/**
 * @extends Result<string>
 */
final class FooResult extends Result
{
    public function __construct(
        private readonly string $value = 'FooResponse',
    ) {}

    public function value(): string
    {
        return $this->value;
    }
}
