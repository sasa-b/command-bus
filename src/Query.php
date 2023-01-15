<?php

declare(strict_types=1);

namespace SasaB\CommandBus;

use SasaB\CommandBus\Concern\CanIdentify;

abstract class Query implements Message
{
    use CanIdentify;

    public function payload(): mixed
    {
        // Override or ignore and use public read only properties
        return null;
    }
}
