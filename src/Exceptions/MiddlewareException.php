<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 14:17
 */

namespace SasaB\CommandBus\Exceptions;


class MiddlewareException extends Exception
{
    public static function invalid($middleware): MiddlewareException
    {
        $name = is_object($middleware) ? get_class($middleware) : gettype($middleware);
        return new static(
            "Invalid middleware '$name' in chain, it does not implement Middleware interface."
        );
    }
}