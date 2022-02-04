<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 16. 12. 2020.
 * Time: 23:31
 */

declare(strict_types=1);

namespace SasaB\CommandBus;

interface Middleware
{
    public function handle(Command $command, \Closure $next): mixed;
}
