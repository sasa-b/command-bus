<?php

declare(strict_types=1);

namespace Sco\MessageBus;

use Sco\MessageBus\Concern\CanIdentify;

/**
 * @template TResult
 */
abstract class Result implements HasIdentity
{
    use CanIdentify;

    /**
     * @return TResult
     */
    abstract public function value(): mixed;
}
