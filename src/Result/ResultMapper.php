<?php

declare(strict_types=1);

namespace Sco\MessageBus\Result;

use Sco\MessageBus\Result;

final class ResultMapper
{
    public function map(mixed $result): Result
    {
        return match (true) {
            $result instanceof Result => $result,
            is_null($result) => new None(),
            is_int($result) => new Integer($result),
            is_float($result) => new Numeric($result),
            is_bool($result) => new Boolean($result),
            is_string($result) => new Text($result),
            is_array($result) && !empty($result) && array_is_list($result) => new Collection($result),
            is_array($result) && !empty($result) && !array_is_list($result) => new Map($result),
            is_array($result) && empty($result) => new Collection($result),
            default => new Delegated($result),
        };
    }
}
