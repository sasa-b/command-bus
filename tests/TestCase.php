<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 11:07
 */

declare(strict_types=1);

namespace Sco\MessageBus\Tests;

use Psr\Container\ContainerInterface;
use Sco\MessageBus\Tests\Stub\Container\InMemoryContainer;
use Sco\MessageBus\Tests\Stub\EchoHandler;
use Sco\MessageBus\Tests\Stub\FailingHandler;
use Sco\MessageBus\Tests\Stub\FooHandler;
use Sco\MessageBus\Tests\Stub\MappedByAttributeHandler;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected ContainerInterface $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = new InMemoryContainer([
            EchoHandler::class => new EchoHandler(),
            FooHandler::class => new FooHandler(),
            FailingHandler::class => new FailingHandler(),
            MappedByAttributeHandler::class => new MappedByAttributeHandler(),
        ]);
    }
}
