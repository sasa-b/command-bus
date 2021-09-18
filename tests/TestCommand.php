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

final class TestCommand implements Command
{
    private string $uuid;

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

    public function getData()
    {
        return $this->data;
    }
}
