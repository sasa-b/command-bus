<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 24/11/2020
 * Time: 16:08
 */

declare(strict_types=1);

namespace Sco\MessageBus;

interface Dispatcher
{
    public function dispatch(Message $message): Result;
}
