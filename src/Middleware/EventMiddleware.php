<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 09:22
 */

namespace SasaB\CommandBus\Middleware;


use SasaB\CommandBus\Command;
use SasaB\CommandBus\Exceptions\Exception;
use SasaB\CommandBus\Middleware;
use SasaB\CommandBus\Events\CommandFailedEvent;
use SasaB\CommandBus\Events\CommandHandledEvent;
use SasaB\CommandBus\Events\CommandReceivedEvent;
use SasaB\CommandBus\Events\Emitter;

final class EventMiddleware implements Middleware
{
    private $emitter;

    public function __construct(Emitter $emitter)
    {
        $this->emitter = $emitter;
    }

    public function handle(Command $command, \Closure $next)
    {
        $this->emitter->emit(new CommandReceivedEvent($command));

        try {

            $result = $next($command);

            $this->emitter->emit(new CommandHandledEvent($command));

        } catch (\Exception $e) {
            $this->emitter->emit(new CommandFailedEvent($command));
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }

        return $result;
    }
}