<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 19:03
 */

declare(strict_types=1);

namespace Sco\MessageBus\Result;

use Sco\MessageBus\Result;

final class Text extends Result
{
    public function __construct(
        public readonly string $value,
    ) {}

    public function payload(): string
    {
        return $this->value;
    }
}
