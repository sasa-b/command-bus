<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 27/11/2020
 * Time: 15:24
 */

declare(strict_types=1);

namespace Sco\MessageBus;

/**
 * @template TM of Message
 */
interface Handler
{
    /**
     * @param TM&Message $message
     *
     * @return void|Result|mixed
     */
    public function __invoke(Message $message);
}
