<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 25/11/2020
 * Time: 15:38
 */

namespace SasaB\CommandBus;


interface Response
{
    public function uuid(): string;

    public function setUuid(string $uuid): Response;

    public function getContent();
}