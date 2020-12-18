<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 11:07
 */

namespace SasaB\CommandBus\Tests;


use SasaB\CommandBus\CommandBus;
use SasaB\CommandBus\Tests\Container\InMemoryContainer;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Psr\Container\ContainerInterface
     */
    protected $container;

    protected function setUp()
    {
        parent::setUp();

        $this->container = new InMemoryContainer([
            EchoTestHandler::class => new EchoTestHandler(),
            TestHandler::class     => new TestHandler()
        ]);
    }
}