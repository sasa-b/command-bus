<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 15. 12. 2020.
 * Time: 21:55
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Tests;

use SasaB\CommandBus\Command;
use SasaB\CommandBus\Handler;

/**
 * @implements Handler<EchoTestCommand>
 */
final class EchoTestHandler implements Handler
{
    public function handle(Command $command): int
    {
        echo $command->payload() . " Successfully Dispatched";
        return 0;
    }
}
