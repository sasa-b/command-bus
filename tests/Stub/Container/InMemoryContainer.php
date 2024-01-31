<?php
/**
 * Created by PhpStorm.
 * User: sasa.blagojevic@mail.com
 * Date: 17. 12. 2020.
 * Time: 11:52
 */

declare(strict_types=1);

namespace Sco\MessageBus\Tests\Stub\Container;

use Psr\Container\ContainerInterface;

final class InMemoryContainer implements ContainerInterface
{
    public function __construct(private readonly array $services) {}

    public function get($id)
    {
        if (!$this->has($id)) {
            throw new ContainerException("Service $id not found");
        }

        return $this->services[$id];
    }

    public function has($id): bool
    {
        return isset($this->services[$id]);
    }
}
