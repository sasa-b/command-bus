<?php

declare(strict_types=1);

namespace SasaB\MessageBus\Middleware\Enforce;

use SasaB\MessageBus\Attribute\IsQuery;
use SasaB\MessageBus\Exception\InvalidResponse;
use SasaB\MessageBus\Message;
use SasaB\MessageBus\Middleware;

final class EmptyResponseMiddleware implements Middleware
{
    public function __invoke(Message $message, \Closure $next): mixed
    {
        $result = $next($message);

        if ($result !== null && $this->isNotQuery($message)) {
            throw InvalidResponse::mutable($message::class);
        }

        return $result;
    }

    private function isNotQuery(Message $message): bool
    {
        return ((new \ReflectionClass($message))->getAttributes(IsQuery::class)[0] ?? null) === null;
    }
}
