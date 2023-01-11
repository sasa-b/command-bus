<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 9. 2021.
 * Time: 23:37
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Tests\Stub;

class TestItemObject
{
    public string $message = 'Item can delegate';

    public function getMessage(): string
    {
        return $this->message;
    }
}
