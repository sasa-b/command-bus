<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 16. 12. 2020.
 * Time: 23:27
 */

namespace SasaB\CommandBus\Events;


use SasaB\CommandBus\Command;

final class CommandFailedEvent implements Event
{
    public function __construct(private Command $command) {}

    public function getName(): string
    {
        return self::class;
    }

    public function getCommand(): Command
    {
        return $this->command;
    }
}
