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
            is_int($response) => new Integer($response),
            is_float($response) => new Numeric($response),
            is_bool($response) => new Boolean($response),
            is_string($response) => new Text($response),
            is_array($response) && !empty($response) && array_is_list($response) => new Collection($response),
            is_array($response) && !empty($response) && !array_is_list($response) => new Map($response),
            is_array($response) && empty($response) => new Collection($response),
            default => new Delegated($response),
        };
    }
}
