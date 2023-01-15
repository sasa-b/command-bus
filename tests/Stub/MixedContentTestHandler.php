<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 13:12
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Tests\Stub;

use SasaB\MessageBus\Handler;
use SasaB\MessageBus\Message;

/**
 * @implements Handler<MixedContentTestCommand>
 */
final class MixedContentTestHandler implements Handler
{
    public function __invoke(Message $message): mixed
    {
        return $message->payload();
    }
}
