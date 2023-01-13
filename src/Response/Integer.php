<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 12:00
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Response;

use SasaB\CommandBus\Response;

final class Integer extends Response
{
    use Concerns\CanIdentify;

    public function __construct(
        public readonly int $value
    ) {}

    public function value(): int
    {
        return $this->value;
    }
}
