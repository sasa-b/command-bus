<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 09:22
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Middleware;

use SasaB\CommandBus\Event\CommandFailedEvent;
use SasaB\CommandBus\Event\CommandHandledEvent;
use SasaB\CommandBus\Event\CommandReceivedEvent;
use SasaB\CommandBus\Event\Emitter;
use SasaB\CommandBus\Exception\MiddlewareException;
use SasaB\CommandBus\Message;
use SasaB\CommandBus\Middleware;

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
