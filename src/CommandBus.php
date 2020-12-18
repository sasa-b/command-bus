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
use SasaB\CommandBus\Response\Void;
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

    private function getHandlerFor(Command $command)
    {
        return $this->diContainer->get(
            $this->mapper->getHandlerName($command)
        );
    }

    public function dispatch(Command $command): Response
    {
        $chain = $this->middlewares;

        $response = $chain($command);

        switch ($response) {
            case null:
                $response = new Void();
                break;
            case is_int($response):
                $response = new Integer($response);
                break;
            case is_float($response):
                $response = new Double($response);
                break;
            case is_bool($response):
                $response = new Boolean($response);
                break;
            case is_string($response):
                $response = new Text($response);
                break;
            case is_array($response):
                $is_map = $response && is_string(array_keys($response)[0]);
                $response = $is_map
                    ? new Map($response)
                    : new Collection($response);
                break;
            case $response instanceof Response:
                // do nothing, it's already a custom response object
                break;
            default:
                $response = new Item($response);
                break;
        }

        return $response->setUuid($command->uuid());
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