<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 12:07
 */

declare(strict_types=1);

namespace Tests {
    use Ramsey\Uuid\Uuid;

    function uuid(): string
    {
        return Uuid::uuid4()->toString();
    }
}
