<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 24/11/2020
 * Time: 16:08
 */

declare(strict_types=1);

namespace SasaB\MessageBus;

interface Dispatcher
{
    public function dispatch(Message $command): Response;
}
