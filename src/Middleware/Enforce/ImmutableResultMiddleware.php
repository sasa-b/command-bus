<?php

declare(strict_types=1);

namespace SasaB\MessageBus\Middleware\Enforce;

use SasaB\MessageBus\Exception\InvalidResult;
use SasaB\MessageBus\Message;
use SasaB\MessageBus\Middleware;

final class ImmutableResultMiddleware implements Middleware
{
    /**
     * @throws \ReflectionException
     */
    public function __invoke(Message $message, \Closure $next): mixed
    {
        $result = $next($message);

        $reflection = new \ReflectionClass($result);

        foreach ($reflection->getProperties() as $property) {
            if (!$property->isReadOnly()) {
                throw InvalidResult::mutable($result::class);
            }
        }

        return $result;
    }
}
