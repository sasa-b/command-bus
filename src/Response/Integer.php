<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 12:00
 */

namespace SasaB\CommandBus\Response;


final class Integer extends Response
{
    public function __construct(
        private int $value
    ) {}

    public function getContent(): int
    {
        return $this->value;
    }
}