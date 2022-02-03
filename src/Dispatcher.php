<?php

/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 24/11/2020
 * Time: 16:08
 */

declare(strict_types=1);

namespace SasaB\CommandBus;

/**
 * @template T as Response
 */
interface Dispatcher
{
    /**
     * @return T
     */
    public function dispatch(Command $command): Response;
}
