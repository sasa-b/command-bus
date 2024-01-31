<?php

declare(strict_types=1);

namespace Sco\MessageBus\Mapper\Strategy;

use Sco\MessageBus\Attribute\IsCommand;
use Sco\MessageBus\Attribute\IsQuery;
use Sco\MessageBus\Exception\HandlerException;
use Sco\MessageBus\Mapper\Mapper;
use Sco\MessageBus\Message;

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
