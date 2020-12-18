<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 11:57
 */

namespace SasaB\CommandBus\Tests\Container;


use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

final class ContainerException extends \Exception implements ContainerExceptionInterface, NotFoundExceptionInterface
{

}