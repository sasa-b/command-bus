<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 16. 12. 2020.
 * Time: 23:27
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Event;

use SasaB\MessageBus\Message;

final class MessageReceivedEvent implements Event
{
    public function __construct(
        private readonly Message $message,
    ) {}

    public function getName(): string
    {
        return self::class;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }
}
