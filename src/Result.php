<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 12:51
 */

declare(strict_types=1);

namespace SasaB\MessageBus;

use SasaB\MessageBus\Concern\CanIdentify;

/**
 * @template T
 */
abstract class Result implements HasIdentity, Payload
{
    use CanIdentify;

    public function payload(): mixed
    {
        // Override or ignore and use public read only properties
        return null;
    }
}
