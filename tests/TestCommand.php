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

final class TestCommand implements Command
{
    use CanIdentify;

    private mixed $data;

    public function __construct(mixed $data = null)
    {
        $this->uuid = uuid();
        $this->data = $data;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function payload(): mixed
    {
        return $this->data;
    }
}
