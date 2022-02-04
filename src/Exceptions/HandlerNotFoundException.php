<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Exceptions;

class HandlerNotFoundException extends Exception
{
    public static function for(string $command, string $handler): self
    {
        return new self("Handler \"$handler\" for \"$command\" not found");
    }

    public static function invalid(string $command): self
    {
        return new self("Invalid handler for $command no value provided");
    }
}
