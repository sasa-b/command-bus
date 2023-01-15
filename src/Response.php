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
 * @template-covariant TR of Response
 */
abstract class Response implements HasIdentity, Payload
{
    use CanIdentify;

    /**
     * @deprecated
     */
    public function content(): mixed
    {
        // This method has been deprecated in favour of Response::payload and will be removed
        return null;
    }

    public function payload(): mixed
    {
        // Override or ignore and use public read only properties
        return null;
    }
}
