<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 15. 12. 2020.
 * Time: 21:55
 */

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub;

use Sco\MessageBus\Handler;
use Sco\MessageBus\Message;

/**
 * @implements Handler<EchoTestCommand>
 */
final class EchoTestHandler implements Handler
{
    public function __invoke(Message $message): int
    {
        echo $message->payload() . " Successfully Dispatched";
        return 0;
    }
}
