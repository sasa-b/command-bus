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
    public function __construct(
        private bool $value
    ) {}

    public function getContent(): bool
    {
        return $this->value;
    }
}