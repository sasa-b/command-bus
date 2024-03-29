<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 11:16
 */

declare(strict_types=1);

namespace Sco\MessageBus\Mapper;

use Sco\MessageBus\Message;

interface Mapper
{
    /**
     * @return class-string
     */
    public function getHandler(Message $message): string;
}
