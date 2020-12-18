<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 09:28
 */

namespace SasaB\CommandBus\Events;


final class Emitter
{
    private $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function emit(Event $event)
    {
        foreach ($this->subscriber->getListeners($event->getName()) as $listener) {
            $listener($event);
        }
    }
}