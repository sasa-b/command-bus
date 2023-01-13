<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 25/11/2020
 * Time: 16:36
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Response;

use SasaB\CommandBus\Response;

final class None extends Response
{
    use Concerns\CanIdentify;

    /**
     * @return null
     */
    public function value(): mixed
    {
        return null;
    }
}
