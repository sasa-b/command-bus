<?php

declare(strict_types=1);

namespace SasaB\MessageBus\Middleware\Enforce;

use SasaB\MessageBus\Attribute\IsCommand;
use SasaB\MessageBus\Command;
use SasaB\MessageBus\Exception\InvalidResponse;
use SasaB\MessageBus\Message;
use SasaB\MessageBus\Middleware;

final class EmptyResponseMiddleware implements Middleware
{
    /**
     * @var array<class-string>
     */
    public static array $exclude = [];

    public function __invoke(Message $message, \Closure $next): mixed
    {
        $result = $next($message);

        if ($result !== null && $this->shouldBeEmpty($message)) {
            throw InvalidResponse::nonEmpty($message::class, $result);
        }

        return $result;
    }

    private function shouldBeEmpty(Message $message): bool
    {
        return ($message instanceof Command || ((new \ReflectionClass($message))->getAttributes(IsCommand::class)[0] ?? null) !== null) && !in_array($message::class, self::$exclude, true);
    }
}
