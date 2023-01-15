<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 11:07
 */

declare(strict_types=1);

namespace SasaB\MessageBus\Tests;

use Psr\Container\ContainerInterface;
use SasaB\MessageBus\Tests\Stub\Container\InMemoryContainer;
use SasaB\MessageBus\Tests\Stub\EchoTestHandler;
use SasaB\MessageBus\Tests\Stub\MixedContentTestHandler;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected ContainerInterface $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = new InMemoryContainer([
            EchoTestHandler::class => new EchoTestHandler(),
            MixedContentTestHandler::class => new MixedContentTestHandler()
        ]);
    }
}
