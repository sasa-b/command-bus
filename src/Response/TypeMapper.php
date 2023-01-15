<?php

declare(strict_types=1);

namespace SasaB\MessageBus\Response;

use SasaB\MessageBus\Response;

final class TypeMapper
{
    public function map(mixed $response): Response
    {
        return match (true) {
            $response instanceof Response => $response,
            is_null($response) => new None(),
            is_int($response) => new Integer(value: $response),
            is_float($response) => new Numeric(value: $response),
            is_bool($response) => new Boolean(value: $response),
            is_string($response) => new Text(value: $response),
            is_array($response) && !empty($response) && array_is_list($response) => new Collection(value: $response),
            is_array($response) && !empty($response) && !array_is_list($response) => new Map(value: $response),
            is_array($response) && empty($response) => new Collection(value: $response),
            default => new Delegated(value: $response),
        };
    }
}
