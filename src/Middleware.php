<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 16. 12. 2020.
 * Time: 23:31
 */

declare(strict_types=1);

namespace Sco\MessageBus;

interface Middleware
{
    public function __invoke(Message $message, \Closure $next): mixed;
}
