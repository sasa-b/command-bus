<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 13:12
 */

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub;

use Sco\MessageBus\Handler;
use Sco\MessageBus\Message;

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
