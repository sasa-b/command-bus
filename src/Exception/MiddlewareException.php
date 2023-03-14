<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 14:17
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Exception;

class MiddlewareException extends Exception
{
    final public static function invalid(mixed $middleware): MiddlewareException
    {
        $name = get_debug_type($middleware);
        return new self(
            \sprintf("Invalid middleware '%s' in chain, it does not implement Middleware interface.", $name)
        );
    }
}
