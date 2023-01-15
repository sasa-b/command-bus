<?php

declare(strict_types=1);

namespace SasaB\MessageBus\Exception;

use SasaB\MessageBus\Event\Event;

class EventException extends Exception
{
    /**
     * @param class-string $event
     */
    public static function invalid(string $event): self
    {
        return new self(\sprintf('%s does not implement %s interface.', $event, Event::class));
    }
}
