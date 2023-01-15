<?php

declare(strict_types=1);

namespace SasaB\MessageBus\Exception;

final class ImmutabilityException extends Exception
{
    /**
     * @param class-string $class
     */
    public static function mutating(string $class): self
    {
        return new self(\sprintf("Trying to mutate an immutable object %s.", $class));
    }
}
