<?php

declare(strict_types=1);

namespace Sco\MessageBus\Middleware\Enforce;

use Sco\MessageBus\Attribute\IsCommand;
use Sco\MessageBus\Command;
use Sco\MessageBus\Exception\InvalidResult;
use Sco\MessageBus\Message;
use Sco\MessageBus\Middleware;

final class EmptyResultMiddleware implements Middleware
{
    /**
     * @var array<class-string>
     */
    public static array $exclude = [];

    public function __invoke(Message $message, \Closure $next): mixed
    {
        $result = $next($message);

        if ($result !== null && $this->shouldBeEmpty($message)) {
            throw InvalidResult::nonEmpty($message::class, $result);
        }

        return $result;
    }

    private function shouldBeEmpty(Message $message): bool
    {
        return ($message instanceof Command || ((new \ReflectionClass($message))->getAttributes(IsCommand::class)[0] ?? null) !== null) && !in_array($message::class, self::$exclude, true);
    }
}
