<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Mapper\Strategy;

use SasaB\CommandBus\Attribute\IsCommand;
use SasaB\CommandBus\Attribute\IsQuery;
use SasaB\CommandBus\Command;
use SasaB\CommandBus\Exceptions\HandlerException;
use SasaB\CommandBus\Mapper\Mapper;

final class MapByAttribute implements Mapper
{
    /**
     * @return class-string
     * @throws HandlerException
     */
    public function getHandler(Command $command): string
    {
        $reflection = new \ReflectionClass($command);

        $attribute = $reflection->getAttributes(IsCommand::class)[0]
            ?? $reflection->getAttributes(IsQuery::class)[0]
            ?? null;

        if ($attribute === null) {
            throw HandlerException::invalid($command::class);
        }

        $attribute = $attribute->newInstance();


        return $attribute->handledBy;
    }
}
