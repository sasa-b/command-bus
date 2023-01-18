<?php

declare(strict_types=1);

namespace SasaB\MessageBus\Mapper\Strategy;

use SasaB\MessageBus\Attribute\IsCommand;
use SasaB\MessageBus\Attribute\IsQuery;
use SasaB\MessageBus\Exception\HandlerException;
use SasaB\MessageBus\Mapper\Mapper;
use SasaB\MessageBus\Message;

final class MapByAttribute implements Mapper
{
    /**
     * @return class-string
     * @throws HandlerException
     */
    public function getHandler(Message $message): string
    {
        $reflection = new \ReflectionClass($message);

        $attribute = $reflection->getAttributes(IsCommand::class)[0]
            ?? $reflection->getAttributes(IsQuery::class)[0]
            ?? null;

        if ($attribute === null) {
            throw HandlerException::invalid($message::class);
        }

        $attribute = $attribute->newInstance();

        return $attribute->handler;
    }
}
