<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 11:57
 */

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub\Container;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

final class ContainerException extends \Exception implements ContainerExceptionInterface, NotFoundExceptionInterface
{
}
