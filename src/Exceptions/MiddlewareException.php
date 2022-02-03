<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 14:17
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Exceptions;

use Throwable;

class MiddlewareException extends Exception
{
    final public static function invalid(mixed $middleware): MiddlewareException
    {
        $name = get_debug_type($middleware);
        return new self(
            "Invalid middleware '$name' in chain, it does not implement Middleware interface."
        );
    }

    final public static function handler(string $handler, Throwable $error): MiddlewareException
    {
        return new self(
            sprintf('Handler % error: %s', $handler, $error->getMessage()),
            $error->getCode(),
            $error
        );
    }
}
