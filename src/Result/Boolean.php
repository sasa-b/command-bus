<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 25/11/2020
 * Time: 16:36
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Result;

use SasaB\MessageBus\Result;

final class Boolean extends Result
{
    public function __construct(
        public readonly bool $value,
    ) {}

    public function payload(): bool
    {
        return $this->value;
    }
}
