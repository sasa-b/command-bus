<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 08:59
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Event;

use SasaB\MessageBus\Exception\EventException;

final class Subscriber
{
    private array $listeners = [
        MessageReceivedEvent::class => [],
        MessageHandledEvent::class  => [],
        MessageFailedEvent::class   => [],
    ];

    /**
     * @param class-string $event
     */
    public function addListener(string $event, \Closure $listener): Subscriber
    {
        $this->validateEvent($event);

        $this->listeners[$event][] = $listener;

        return $this;
    }

    /**
     * @param class-string $event
     */
    public function removeListener(string $event, int $index = null): Subscriber
    {
        $this->validateEvent($event);

        if ($index === null) {
            array_pop($this->listeners[$event]);
            return $this;
        }

        unset($this->listeners[$event][$index]);

        $this->listeners[$event] = array_values($this->listeners[$event]);

        return $this;
    }

    /**
     * @param class-string $event
     */
    public function removeAllListeners(string $event): Subscriber
    {
        $this->validateEvent($event);

        $this->listeners[$event] = [];

        return $this;
    }

    /**
     * @param class-string $event
     */
    public function getListeners(string $event): array
    {
        $this->validateEvent($event);

        return $this->listeners[$event];
    }

    /**
     * @param class-string $event
     * @throws EventException
     */
    private function validateEvent(string $event): void
    {
        if (!array_key_exists($event, $this->listeners)) {
            throw EventException::invalid($event);
        }
    }
}
