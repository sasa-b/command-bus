<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 11:16
 */

namespace SasaB\CommandBus;


final class MapByName implements Mapper
{
    public function getHandlerName(Command $command): string
    {
        return preg_replace('/(Request|Command|Query)$/', 'Handler', get_class($command));
    }
}
