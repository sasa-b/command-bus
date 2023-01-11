<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 11:16
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Mapper;

use SasaB\CommandBus\Command;

interface Mapper
{
    /**
     * @return class-string
     */
    public function getHandler(Command $command): string;
}
