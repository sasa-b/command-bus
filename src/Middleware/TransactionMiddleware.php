<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 16. 12. 2020.
 * Time: 23:36
 */

namespace SasaB\CommandBus\Middleware;


use SasaB\CommandBus\Command;
use SasaB\CommandBus\Middleware;
use SasaB\CommandBus\Exceptions\Exception;

final class TransactionMiddleware implements Middleware
{
    public function __construct(
        private \Closure $begin,
        private \Closure $commit,
        private \Closure $rollback
    ){}

    public function handle(Command $command, \Closure $next)
    {
        call_user_func($this->begin);
        try {
            $result = $next($command);
        } catch (\Exception $e) {
            call_user_func($this->rollback);
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }
        call_user_func($this->commit);
        return $result;
    }
}