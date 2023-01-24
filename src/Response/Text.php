<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 19:03
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Response;

use SasaB\MessageBus\Response;

final class Text extends Response
{
    public function __construct(
        public readonly string $value,
    ) {}

    public function payload(): string
    {
        return $this->value;
    }
}
