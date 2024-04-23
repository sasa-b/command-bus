<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 09:05
 */

declare(strict_types=1);

namespace Sco\MessageBus\Event;

interface Event
{
    /**
     * @return class-string
     */
    public function getName(): string;
}
