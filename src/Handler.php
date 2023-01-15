<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 27/11/2020
 * Time: 15:24
 */

declare(strict_types=1);

namespace SasaB\CommandBus;

/**
 * @template TC of Message
 */
interface Handler
{
    /**
     * @param TC $command
     */
    public function __invoke(Message $command): mixed;
}
