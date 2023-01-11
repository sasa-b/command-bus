<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 25/11/2020
 * Time: 16:34
 */

declare(strict_types=1);

namespace SasaB\CommandBus;

use Closure;
use Psr\Container\ContainerInterface;
use SasaB\CommandBus\Exceptions\MiddlewareException;
use SasaB\CommandBus\Mapper\Mapper;
use SasaB\CommandBus\Mapper\Strategy\MapByName;
use SasaB\CommandBus\Response\TypeMapper;

final class Bus implements Dispatcher
{
    private Closure $chain;

    private Mapper $mapper;

    private Identity $identity;

    private TypeMapper $typeMapper;

    /**
     * @param ContainerInterface $container
     * @param array $middlewares
     * @param Mapper|null $mapper
     * @param Identity|null $identity
     * @throws MiddlewareException
     */
    public function __construct(
        private ContainerInterface $container,
        array $middlewares = [],
        ?Mapper $mapper = null,
        ?Identity $identity = null
    ) {
        $this->chain = $this->createMiddlewareChain($middlewares);
        $this->mapper = $mapper ?? new MapByName();
        $this->identity = $identity ?? new RandomStringIdentity();
        $this->typeMapper = new TypeMapper();
    }

    private function getHandlerFor(Command $command): Handler
    {
        return $this->container->get(
            $this->mapper->getHandler($command)
        );
    }

    public function dispatch(Command $command): Response
    {
        $command->setUuid(
            $this->identity->generate()
        );

        return $this->typeMapper->map(
            ($this->chain)($command)
        )->setUuid($command->uuid());
    }

    /**
     * @param array<Middleware> $chain
     * @throws MiddlewareException
     */
    private function createMiddlewareChain(array $chain): Closure
    {
        $lastMiddleware = fn (Command $command) => $this->getHandlerFor($command)->handle($command);

        while ($middleware = array_pop($chain)) {
            if (!$middleware instanceof Middleware) {
                throw MiddlewareException::invalid($middleware);
            }

            $lastMiddleware = fn (Command $command) => ($middleware)($command, $lastMiddleware);
        }

        return $lastMiddleware;
    }
}
