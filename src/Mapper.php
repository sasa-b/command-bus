<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 11:16
 */

namespace SasaB\CommandBus;


interface Mapper
{
    public function getHandlerName(Command $command): string;
}