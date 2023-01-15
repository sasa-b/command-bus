<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 12:03
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Response;

use SasaB\CommandBus\Response;

final class Numeric extends Response
{
    public function __construct(
        public readonly float $value
    ) {}

    public function value(): float
    {
        return $this->value;
    }
}
