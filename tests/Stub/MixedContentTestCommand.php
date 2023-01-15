<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 18. 12. 2020.
 * Time: 11:30
 */

declare(strict_types=1);

namespace SasaB\CommandBus\Tests\Stub;

use SasaB\CommandBus\Command;
use SasaB\CommandBus\Concern\CanIdentify;

use function Tests\uuid;

final class MixedContentTestCommand implements Command
{
    use CanIdentify;

    public function __construct(public mixed $data = null)
    {
        $this->setUuid(uuid());
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function payload(): mixed
    {
        return $this->data;
    }
}
