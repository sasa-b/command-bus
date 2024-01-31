<?php

declare(strict_types=1);

namespace Sco\MessageBus\Exception;

class InvalidResult extends Exception
{
    /**
     * @param class-string $class
     */
    final public static function mutable(string $class): self
    {
        return new self(\sprintf("%s can only have readonly properties", $class));
    }

    /**
     * @param class-string $class
     */
    final public static function nonEmpty(string $class, mixed $value): self
    {
        return new self(\sprintf("Commands cannot return values other than null. %s returns %s.", $class, gettype($value)));
    }
}
