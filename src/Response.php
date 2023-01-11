<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 12:51
 */

declare(strict_types=1);

namespace SasaB\CommandBus;

/**
 * @template-covariant TR of Response
 */
abstract class Response implements HasIdentity
{
    public function content(): mixed
    {
        // Override or ignore and use public read only properties
        return null;
    }
}
