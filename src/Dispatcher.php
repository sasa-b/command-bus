<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 24/11/2020
 * Time: 16:08
 */

namespace SasaB\CommandBus;


interface Dispatcher
{
    public function dispatch(Command $command): Response;
}