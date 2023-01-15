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

final class CommandReceivedEvent implements Event
{
    public function __construct(
        private readonly Message $command
    ) {}

    public function getName(): string
    {
        return self::class;
    }

    public function getCommand(): Message
    {
        return $this->command;
    }
}
