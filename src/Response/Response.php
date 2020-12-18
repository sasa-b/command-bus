<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 12:51
 */

namespace SasaB\CommandBus\Response;


use SasaB\CommandBus\Response as Contract;

abstract class Response implements Contract
{
    protected $uuid;

    public function setUuid(string $uuid): Contract
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function uuid(): string
    {
        return $this->uuid;
    }
}