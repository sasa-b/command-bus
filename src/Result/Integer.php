<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 12:00
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Result;

use SasaB\MessageBus\Result;

final class Integer extends Result
{
    public function __construct(
        public readonly int $value,
    ) {}

    public function payload(): int
    {
        return $this->value;
    }
}
