<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 11:30
 */

namespace SasaB\CommandBus\Tests;


use SasaB\CommandBus\Command;
use function Tests\uuid;

final class EchoTestCommand implements Command
{
    private string $uuid;

    private string $message;

    public function __construct(string $message)
    {
        $this->uuid = uuid();
        $this->message = $message;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
