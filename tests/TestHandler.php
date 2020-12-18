<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 13:12
 */

namespace SasaB\CommandBus\Tests;


use SasaB\CommandBus\Command;
use SasaB\CommandBus\Handler;
use SasaB\CommandBus\Tests\Commands\TestCommand;

final class TestHandler implements Handler
{
    /**
     * @param Command|TestCommand $command
     * @return mixed
     */
    public function handle(Command $command)
    {
        return $command->getData();
    }
}