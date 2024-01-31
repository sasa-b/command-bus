<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 11:16
 */

declare(strict_types=1);

namespace Sco\MessageBus\Mapper\Strategy;

use Sco\MessageBus\Exception\HandlerException;
use Sco\MessageBus\Mapper\Mapper;
use Sco\MessageBus\Message;

final class MapByName implements Mapper
{
    /**
     * @return class-string
     *@throws HandlerException
     */
    public function getHandler(Message $message): string
    {
        $handler = preg_replace('/(Command|Query)$/', 'Handler', $message::class);

        if (empty($handler)) {
            throw HandlerException::invalid($message::class);
        }

        if (!class_exists($handler)) {
            throw HandlerException::notFound($message::class, $handler);
        }

        return $handler;
    }
}
