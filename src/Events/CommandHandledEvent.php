<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 16. 12. 2020.
 * Time: 23:27
 */

namespace SasaB\CommandBus\Events;


use SasaB\CommandBus\Command;

final class CommandHandledEvent implements Event
{
    private $command;

    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    public function getName(): string
    {
        return self::class;
    }

    public function getCommand(): Command
    {
        return $this->command;
    }
}