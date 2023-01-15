<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 11:00
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Event;

interface Listener
{
    public function __invoke(Event $event): void;
}
