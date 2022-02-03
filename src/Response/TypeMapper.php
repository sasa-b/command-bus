<?php

declare(strict_types=1);

namespace SasaB\CommandBus\Response;

use SasaB\CommandBus\Response;

final class TypeMapper
{
    public function map(mixed $response): Response
    {
        return match (true) {
            $response instanceof Response => $response,
            is_null($response) => new None(content: null),
            is_int($response) => new Integer(content: $response),
            is_float($response) => new Double(content: $response),
            is_bool($response) => new Boolean(content: $response),
            is_string($response) => new Text(content: $response),
            is_array($response) && !empty($response) && array_is_list($response) => new Collection(content: $response),
            is_array($response) && !empty($response) && !array_is_list($response) => new Map(content: $response),
            is_array($response) && empty($response) => new Collection(content: $response),
            default => new Delegated(content: $response),
        };
    }
}
