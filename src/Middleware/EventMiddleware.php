<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 09:22
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Middleware;

use SasaB\CommandBus\Command;
use SasaB\CommandBus\Events\CommandFailedEvent;
use SasaB\CommandBus\Events\CommandHandledEvent;
use SasaB\CommandBus\Events\CommandReceivedEvent;
use SasaB\CommandBus\Events\Emitter;
use SasaB\CommandBus\Exceptions\MiddlewareException;
use SasaB\CommandBus\Middleware;

final class EventMiddleware implements Middleware
{
    public function __construct(
        private Emitter $emitter
    ) {
    }

    public function handle(Command $command, \Closure $next)
    {
        $this->emitter->emit(new CommandReceivedEvent($command));

        try {
            $result = $next($command);

            $this->emitter->emit(new CommandHandledEvent($command));
        } catch (\Exception $e) {
            $this->emitter->emit(new CommandFailedEvent($command));
            throw MiddlewareException::handler(handler: __CLASS__, error: $e);
        }

        return $result;
    }
}
