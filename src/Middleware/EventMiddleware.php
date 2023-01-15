<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 09:22
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Middleware;

use SasaB\MessageBus\Event\CommandFailedEvent;
use SasaB\MessageBus\Event\CommandHandledEvent;
use SasaB\MessageBus\Event\CommandReceivedEvent;
use SasaB\MessageBus\Event\Emitter;
use SasaB\MessageBus\Exception\MiddlewareException;
use SasaB\MessageBus\Message;
use SasaB\MessageBus\Middleware;

final class EventMiddleware implements Middleware
{
    public function __construct(
        private readonly Emitter $emitter
    ) {}

    public function __invoke(Message $message, \Closure $next): mixed
    {
        $this->emitter->emit(new CommandReceivedEvent($message));

        try {
            $result = $next($message);

            $this->emitter->emit(new CommandHandledEvent($message));
        } catch (\Exception $e) {
            $this->emitter->emit(new CommandFailedEvent($message));
            throw MiddlewareException::handler(handler: __CLASS__, error: $e);
        }

        return $result;
    }
}
