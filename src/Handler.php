<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 27/11/2020
 * Time: 15:24
 */

namespace SasaB\CommandBus;


interface Handler
{
    public function handle(AbstractCommand|Command $command);
}
