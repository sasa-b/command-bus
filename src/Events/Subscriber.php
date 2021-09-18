<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 08:59
 */

namespace SasaB\CommandBus\Events;


final class Subscriber
{
    private array $listeners = [
        CommandFailedEvent::class   => [],
        CommandHandledEvent::class  => [],
        CommandReceivedEvent::class => []
    ];

    public function addListener(string $event, \Closure $listener): Subscriber
    {
        $this->listeners[$event][] = $listener;
        return $this;
    }

    public function removeListener(string $event, int $index = null): Subscriber
    {
       if ($index === null) {
           array_pop($this->listeners[$event]);
           return $this;
       }

       unset($this->listeners[$event][$index]);

       $this->listeners[$event] = array_values($this->listeners[$event]);

       return $this;
    }

    public function getListeners(string $event): array
    {
        return $this->listeners[$event];
    }
}
