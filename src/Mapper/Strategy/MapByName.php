<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 11:16
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Mapper\Strategy;

use SasaB\CommandBus\Exception\HandlerException;
use SasaB\CommandBus\Mapper\Mapper;
use SasaB\CommandBus\Message;

final class MapByName implements Mapper
{
    /**
     * @return class-string
     *@throws HandlerException
     */
    public function getHandler(Message $command): string
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
