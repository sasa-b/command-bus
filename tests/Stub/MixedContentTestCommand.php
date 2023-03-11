<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 11:30
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Tests\Stub;

use SasaB\MessageBus\Command;

use function Tests\uuid;

final class MixedContentTestCommand extends Command
{
    public function __construct(public mixed $data = null)
    {
        $this->setId(uuid());
    }

    public function payload(): mixed
    {
        return $this->data;
    }
}
