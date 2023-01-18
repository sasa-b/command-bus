<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 09:28
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Event;

final class Emitter
{
    public function __construct(
        private readonly Subscriber $subscriber,
    ) {}

    public function emit(Event $event): void
    {
        foreach ($this->subscriber->getListeners($event->getName()) as $listener) {
            $listener($event);
        }
    }
}
