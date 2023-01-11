<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 11:16
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Mapper\Strategy;

use SasaB\CommandBus\Command;
use SasaB\CommandBus\Exceptions\HandlerException;
use SasaB\CommandBus\Mapper\Mapper;

final class MapByName implements Mapper
{
    /**
     * @return class-string
     *@throws HandlerException
     */
    public function getHandler(Command $command): string
    {
        $handler = preg_replace('/(Request|Command|Query)$/', 'Handler', $command::class);

        if (empty($handler)) {
            throw HandlerException::invalid($command::class);
        }

        if (!class_exists($handler)) {
            throw HandlerException::notFound($command::class, $handler);
        }

        return $handler;
    }
}
