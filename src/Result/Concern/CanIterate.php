<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 00:04
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Result\Concern;

use ArrayIterator;

trait CanIterate
{
    public function getIterator(): \Traversable
    {
        return new ArrayIterator($this->value);
    }
}
