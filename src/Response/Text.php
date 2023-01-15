<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 19:03
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Response;

use SasaB\CommandBus\Response;

final class Text extends Response
{
    public function __construct(
        public readonly string $value
    ) {}

    public function value(): string
    {
        return $this->value;
    }
}
