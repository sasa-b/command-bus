<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Exceptions;

class ImmutableException extends Exception
{
    public static function mutating(string $class): self
    {
        return new self("Trying to mutate an immutable response $class");
    }
}
