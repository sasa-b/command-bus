<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 12:03
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Response;

use SasaB\CommandBus\Response;

final class Double extends Response
{
    use Concerns\CanIdentify;

    public function __construct(
        public readonly float $content
    ) {
    }

    public function content(): float
    {
        return $this->content;
    }
}
