<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 25/11/2020
 * Time: 16:36
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Response;

use SasaB\CommandBus\Response;

class Delegated extends Response
{
    use Concerns\CanDelegate;
    use Concerns\CanIdentify;

    public function __construct(
        public readonly object $content
    ) {
    }

    public function content(): object
    {
        return $this->content;
    }
}
