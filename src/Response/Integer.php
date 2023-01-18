<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 12:00
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Response;

use SasaB\MessageBus\Response;

final class Integer extends Response
{
    public function __construct(
        public readonly int $value,
    ) {}

    public function value(): int
    {
        return $this->value;
    }
}
