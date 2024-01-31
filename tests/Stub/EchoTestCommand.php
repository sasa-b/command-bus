<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 11:30
 */

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub;

use Sco\MessageBus\Concern\CanIdentify;
use Sco\MessageBus\Message;

use function Tests\uuid;

final class EchoTestCommand implements Message
{
    use CanIdentify;

    public function __construct(public string $message)
    {
        $this->setId(uuid());
    }

    public function payload(): string
    {
        return $this->message;
    }
}
