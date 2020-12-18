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
    private $uuid;

    private $dataType;

    private $data;

    public function __construct(string $dataType, $data = null)
    {
        $this->uuid = uuid();
        $this->dataType = $dataType;
        $this->data = $data;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function toArray(): array
    {
        return [
            'data'      => $this->data,
            'data_type' => $this->dataType
        ];
    }

    public function getData()
    {
        return $this->data;
    }

    public function getDataType(): string
    {
        return $this->dataType;
    }
}