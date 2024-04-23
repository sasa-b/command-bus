<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 09:22
 */

declare(strict_types=1);

namespace Sco\MessageBus\Middleware;

use Sco\MessageBus\Event\Emitter;
use Sco\MessageBus\Event\MessageFailedEvent;
use Sco\MessageBus\Event\MessageHandledEvent;
use Sco\MessageBus\Event\MessageReceivedEvent;
use Sco\MessageBus\Message;
use Sco\MessageBus\Middleware;

final readonly class EventMiddleware implements Middleware
{
    public function __construct(
        private Emitter $emitter,
    ) {}

    public function __invoke(Message $message, \Closure $next): mixed
    {
        $this->emitter->emit(new MessageReceivedEvent($message));

        try {
            $result = $next($message);

            $this->emitter->emit(new MessageHandledEvent($message, $result));
        } catch (\Exception $e) {
            $this->emitter->emit(new MessageFailedEvent($message, $e));
            throw $e;
        }

        return $result;
    }
}
