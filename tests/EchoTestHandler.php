<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 15. 12. 2020.
 * Time: 21:55
 */

namespace SasaB\CommandBus\Tests;

use SasaB\CommandBus\Command;
use SasaB\CommandBus\Handler;

final class EchoTestHandler implements Handler
{
    public function handle(Command $command)
    {
        echo $command->getMessage() . " Successfully Dispatched";

        return 0;
    }
}
