<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 15. 12. 2020.
 * Time: 21:55
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Tests\Stub;

use SasaB\CommandBus\Handler;
use SasaB\CommandBus\Message;

/**
 * @implements Handler<EchoTestMessage>
 */
final class EchoTestHandler implements Handler
{
    public function __invoke(Message $message): int
    {
        echo $message->payload() . " Successfully Dispatched";
        return 0;
    }
}
