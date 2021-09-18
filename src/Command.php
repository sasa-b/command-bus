<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 25/11/2020
 * Time: 15:20
 */

namespace SasaB\CommandBus;


/**
 * @deprecated @method toArray(): array
 */
interface Command
{
    public function uuid(): string;
}
