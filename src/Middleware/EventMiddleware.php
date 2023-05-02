<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 09:22
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Middleware;

use SasaB\MessageBus\Event\Emitter;
use SasaB\MessageBus\Event\MessageFailedEvent;
use SasaB\MessageBus\Event\MessageHandledEvent;
use SasaB\MessageBus\Event\MessageReceivedEvent;
use SasaB\MessageBus\Message;
use SasaB\MessageBus\Middleware;
use SasaB\MessageBus\Result\ResultMapper;

final class EventMiddleware implements Middleware
{
    public function __construct(
        private readonly Emitter $emitter,
        private readonly ResultMapper $resultMapper,
    ) {}

    public function __invoke(Message $message, \Closure $next): mixed
    {
        $this->emitter->emit(new MessageReceivedEvent($message));

        try {
            $result = $next($message);

            $this->emitter->emit(new MessageHandledEvent($message, $this->resultMapper->map($result)));
        } catch (\Exception $e) {
            $this->emitter->emit(new MessageFailedEvent($message, $e));
            throw $e;
        }

        return $result;
    }
}
