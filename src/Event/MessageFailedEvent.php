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

final readonly class MessageFailedEvent implements Event
{
    public function __construct(
        public Message $message,
        public \Throwable $error,
    ) {}

    public function getName(): string
    {
        return self::class;
    }
}
