<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 13:12
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Tests\Stub;

use SasaB\CommandBus\Handler;
use SasaB\CommandBus\Message;

/**
 * @implements Handler<MixedContentTestMessage>
 */
final class MixedContentTestHandler implements Handler
{
    public function __invoke(Message $message): mixed
    {
        return $message->payload();
    }
}
