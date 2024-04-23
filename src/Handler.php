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
 * @template TMessage of Message
 * @template TResult
 */
interface Handler
{
    /**
     * @param TMessage $message
     * @return TResult
     */
    public function __invoke(Message $message);
}
