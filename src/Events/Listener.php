<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 11:00
 */

namespace SasaB\CommandBus\Events;


interface Listener
{
    public function __invoke(Event $event);
}