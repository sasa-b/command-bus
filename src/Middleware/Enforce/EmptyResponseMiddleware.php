<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Middleware\Enforce;

use SasaB\CommandBus\Attribute\IsQuery;
use SasaB\CommandBus\Exception\InvalidResponse;
use SasaB\CommandBus\Message;
use SasaB\CommandBus\Middleware;

final class EmptyResponseMiddleware implements Middleware
{
    public function __invoke(Message $command, \Closure $next): mixed
    {
        $result = $next($command);

        if ($result !== null && $this->isNotQuery($command)) {
            throw InvalidResponse::mutable($command::class);
        }

        return $result;
    }

    private function isNotQuery(Message $command): bool
    {
        return ((new \ReflectionClass($command))->getAttributes(IsQuery::class)[0] ?? null) === null;
    }
}
