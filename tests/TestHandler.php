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

final class TestHandler implements Handler
{
    public function handle(Command $command)
    {
        return $command->getData();
    }
}
