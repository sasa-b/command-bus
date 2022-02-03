<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 09:05
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Events;

use SasaB\CommandBus\Command;

interface Event
{
    public function getName(): string;

    public function getCommand(): Command;
}
