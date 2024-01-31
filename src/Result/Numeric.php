<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 12:03
 */

declare(strict_types=1);

namespace Sco\MessageBus\Result;

use Sco\MessageBus\Result;

final class Numeric extends Result
{
    public function __construct(
        public readonly float $value,
    ) {}

    public function payload(): float
    {
        return $this->value;
    }
}
