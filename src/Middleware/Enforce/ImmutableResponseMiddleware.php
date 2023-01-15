<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Middleware\Enforce;

use SasaB\CommandBus\Exception\InvalidResponse;
use SasaB\CommandBus\Message;
use SasaB\CommandBus\Middleware;

final class ImmutableResponseMiddleware implements Middleware
{
    /**
     * @throws \ReflectionException
     */
    public function __invoke(Message $command, \Closure $next): mixed
    {
        $result = $next($command);

        $reflection = new \ReflectionClass($result);

        foreach ($reflection->getProperties() as $property) {
            if (!$property->isReadOnly()) {
                throw InvalidResponse::mutable($result::class);
            }
        }

        return $result;
    }
}
