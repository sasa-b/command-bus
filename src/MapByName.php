<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 11:16
 */

declare(strict_types=1);

namespace SasaB\CommandBus;

use SasaB\CommandBus\Exceptions\HandlerNotFoundException;

final class MapByName implements Mapper
{
    /**
     * @throws HandlerNotFoundException
     * @return class-string
     */
    public function getHandlerName(Command $command): string
    {
        $handler = preg_replace('/(Request|Command|Query)$/', 'Handler', $command::class);

        if (empty($handler)) {
            throw HandlerNotFoundException::invalid($command::class);
        }

        if (!class_exists($handler)) {
            throw HandlerNotFoundException::for($command::class, $handler);
        }

        return $handler;
    }
}
