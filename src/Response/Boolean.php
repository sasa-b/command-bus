<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 25/11/2020
 * Time: 16:36
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Response;

use SasaB\MessageBus\Response;

final class Boolean extends Response
{
    public function __construct(
        public readonly bool $value,
    ) {}

    public function payload(): bool
    {
        return $this->value;
    }
}
