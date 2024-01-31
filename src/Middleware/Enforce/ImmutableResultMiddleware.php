<?php

declare(strict_types=1);

namespace Sco\MessageBus\Middleware\Enforce;

use Sco\MessageBus\Exception\InvalidResult;
use Sco\MessageBus\Message;
use Sco\MessageBus\Middleware;

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
