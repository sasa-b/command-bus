<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 25/11/2020
 * Time: 15:20
 */

namespace SasaB\CommandBus;


interface Command
{
    public function uuid(): string;

    public function toArray(): array;
}