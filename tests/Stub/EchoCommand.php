<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 11:30
 */

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub;

use Sco\MessageBus\Message;

final class EchoCommand implements Message
{
    public function __construct(
        public string $message,
    ) {}

    public function payload(): string
    {
        return $this->message;
    }
}
