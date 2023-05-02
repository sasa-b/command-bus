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

class Delegated extends Result
{
    use Concern\CanDelegate;

    public function __construct(
        public readonly object $value,
    ) {}

    public function payload(): object
    {
        return $this->value;
    }
}
