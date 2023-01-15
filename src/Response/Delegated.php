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

class Delegated extends Response
{
    use Concern\CanDelegate;

    public function __construct(
        public readonly object $value
    ) {}

    public function value(): object
    {
        return $this->value;
    }
}
