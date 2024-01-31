<?php

declare(strict_types=1);

namespace Sco\MessageBus\Exception;

final class HandlerException extends Exception
{
    public static function notFound(string $message, string $handler): self
    {
        return new self("Handler class \"$handler\" for \"$message\" does not exist.");
    }

    public static function invalid(string $message): self
    {
        return new self("Invalid handler for $message no value provided.");
    }
}
