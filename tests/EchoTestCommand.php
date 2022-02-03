<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 11:30
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Tests;

use SasaB\CommandBus\Command;
use SasaB\CommandBus\Response\Concerns\CanIdentify;
use function Tests\uuid;

final class EchoTestCommand implements Command
{
    use CanIdentify;

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

    public function payload(): string
    {
        return $this->message;
    }

    public function echo(): void
    {
    }
}
