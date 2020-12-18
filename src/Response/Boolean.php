<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 25/11/2020
 * Time: 16:36
 */

namespace SasaB\CommandBus\Response;


final class Boolean extends Response
{
    private $value;

    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    public function getContent(): bool
    {
        return $this->value;
    }
}