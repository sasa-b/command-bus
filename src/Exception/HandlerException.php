<?php

declare(strict_types=1);

namespace SasaB\MessageBus\Exception;

final class HandlerException extends Exception
{
    public static function notFound(string $command, string $handler): self
    {
        return new self("Handler class \"$handler\" for \"$command\" does not exist.");
    }

    public static function invalid(string $command): self
    {
        return new self("Invalid handler for $command no value provided.");
    }
}
