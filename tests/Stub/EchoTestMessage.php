<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 11:30
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Tests\Stub;

use SasaB\CommandBus\Concern\CanIdentify;
use SasaB\CommandBus\Message;

use function Tests\uuid;

final class EchoTestMessage implements Message
{
    use CanIdentify;

    public function __construct(public string $message)
    {
        $this->setUuid(uuid());
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function payload(): string
    {
        return $this->message;
    }
}