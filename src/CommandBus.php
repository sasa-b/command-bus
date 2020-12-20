<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 25/11/2020
 * Time: 16:34
 */

namespace SasaB\CommandBus;


use Psr\Container\ContainerInterface;

use SasaB\CommandBus\Exceptions\MiddlewareException;
use SasaB\CommandBus\Response\Map;
use SasaB\CommandBus\Response\Item;
use SasaB\CommandBus\Response\Text;
use SasaB\CommandBus\Response\None;
use SasaB\CommandBus\Response\Double;
use SasaB\CommandBus\Response\Integer;
use SasaB\CommandBus\Response\Boolean;
use SasaB\CommandBus\Response\Collection;


final class CommandBus implements Dispatcher
{
    private $diContainer;

    private $middlewares;

    private $mapper;

    public function __construct(ContainerInterface $diContainer, array $middleware = [], Mapper $mapper = null)
    {
        $this->diContainer = $diContainer;
        $this->middlewares = $this->createMiddlewareChain($middleware);
        $this->mapper = $mapper ?? new MapByName();
    }

    private function getHandlerFor(Command $command): Handler
    {
        return $this->diContainer->get(
            $this->mapper->getHandlerName($command)
        );
    }

    public function dispatch(Command $command): Response
    {
        $chain = $this->middlewares;

        $response = $this->parseResponse(
            $chain($command)
        );

        return $response->setUuid($command->uuid());
    }

    private function parseResponse($response)
    {
        switch ($response) {
            case null:
                return new None();
            case is_int($response):
                return new Integer($response);
            case is_float($response):
                return new Double($response);
            case is_bool($response):
                return new Boolean($response);
            case is_string($response):
                return new Text($response);
            case is_array($response):
                return $response && is_string(array_keys($response)[0])
                    ? new Map($response)
                    : new Collection($response);
            case $response instanceof Response:
                // do nothing, it's already a custom response object
                return $response;
            default:
                return new Item($response);
        }
    }

    private function createMiddlewareChain(array $chain): \Closure
    {
        $lastMiddleware = function ($command) {
            return $this->getHandlerFor($command)->handle($command);
        };

        while ($middleware = array_pop($chain)) {
            if (!$middleware instanceof Middleware) {
                throw MiddlewareException::invalid($middleware);
            }

            $lastMiddleware = function ($command) use ($middleware, $lastMiddleware) {
                return $middleware->handle($command, $lastMiddleware);
            };
        }

        return $lastMiddleware;
    }
}