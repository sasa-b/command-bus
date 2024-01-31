<?php

declare(strict_types=1);

namespace Sco\MessageBus;

use Sco\MessageBus\Concern\CanIdentify;

abstract class Command implements Message
{
    use CanIdentify;

    public function payload(): mixed
    {
        // Override or ignore and use public read only properties
        return null;
    }
}
