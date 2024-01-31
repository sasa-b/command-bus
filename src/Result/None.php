<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 25/11/2020
 * Time: 16:36
 */

declare(strict_types=1);

namespace Sco\MessageBus\Result;

use Sco\MessageBus\Result;

final class None extends Result
{
    /**
     * @return null
     */
    public function payload(): mixed
    {
        return null;
    }
}
