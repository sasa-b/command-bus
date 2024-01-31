<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 16. 12. 2020.
 * Time: 23:27
 */

declare(strict_types=1);

namespace Sco\MessageBus\Event;

use Sco\MessageBus\Message;

final class MessageFailedEvent implements Event
{
    public function __construct(
        private readonly Message $message,
        private readonly \Throwable $error,
    ) {}

    public function getName(): string
    {
        return self::class;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function getError(): \Throwable
    {
        return $this->error;
    }
}
