# Message Bus Pattern 

Colloquially more known as **Command Bus** pattern, but the library makes a distinction between **Commands** and **Queries** and allows you to 
enforce no return values in Command Handlers to keep you in line with [CQRS pattern](https://martinfowler.com/bliki/CQRS.html).

This is a **stand-alone library**, the only two dependencies being the [PSR-11 Container](https://www.php-fig.org/psr/psr-11/) and [PSR-3 Log](https://www.php-fig.org/psr/psr-3/) interfaces to allow for better 
interoperability.

**Table of Contents:**
* [Getting Started](#getting-started)
    * [Stand-alone usage](#stand-alone-usage)
    * [Using with Symfony Framework](#using-with-symfony-framework)
    * [Using with Laravel Framework](#using-with-laravel-framework)
* [Core Concepts](#core-concepts)
  * [Identity](#identity)
  * [Handler Mapping Strategy](#handler-mapping-strategy)
  * [Middleware](#middleware)
  * [Event](#event)
  * [Transaction](#transaction)
  * [Result Types](#result-types)

## Getting Started

Install the library using composer:
```bash
composer require sco/message-bus
```

### Stand-alone usage

You will need to follow the [PSR-4 autoloading standard](https://www.php-fig.org/psr/psr-4/) and either create your own Service Container class, which is a matter of implementing the `Psr\Container\ContainerInterface` and can be as simple as what
the library is using for its test suite `Sco\MessageBus\Tests\Stub\Container\InMemoryContainer`, or you can composer require a Service Container library which
adheres to the [PSR-11 Standard](https://www.php-fig.org/psr/psr-11/) like [PHP-DI](https://php-di.org/).

```php
require 'vendor/autoload.php'

$container = new InMemoryContainer($services)

$bus = new \Sco\MessageBus\Bus($container);

$bus->dispatch(new FindPostByIdQuery(1))
```

### Using with Symfony Framework

We can use two approaches here, decorating the Bus class provided by the library, or injecting the Service Locator. For more
info you can read [Symfony Docs](https://symfony.com/doc/current/service_container/service_subscribers_locators.html)

#### Decorating the Bus
We can create a new Decorator class which will implement Symfony's `Symfony\Contracts\Service\ServiceSubscriberInterface` interface:

```php
use Sco\MessageBus\Bus;
use Sco\MessageBus\Message;
use Sco\MessageBus\Result;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class MessageBus implements ServiceSubscriberInterface
{
    private Bus $bus;

    public function __construct(ContainerInterface $locator)
    {
        $this->bus = new Bus($locator, [], null, new UuidV4Identity());
    }

    public function dispatch(\Sco\MessageBus\Message $message): Result
    {
        return $this->bus->dispatch($message);
    }

    public static function getSubscribedServices(): array
    {
        return [
            FindPostByIdHandler::class,
            SavePostHandler::class
        ];
    }
}
```
With this approach all handlers in you application will have to be added to the array returned by `getSubscribedServices`, since services in Symfony are not
public by default, and they really shouldn't be, so unless you add your handlers to this array when the mapper is done mapping
it won't be able to find the handler and a service not found container exception will be thrown.

#### Injecting the ServiceLocator

A different approach would be to inject a Service Locator with all the handlers into the library's Bus. This would be done in the
service registration yaml files.

Anonymous service locator:
```yaml
services:
    _defaults:
      autowire: true      
      autoconfigure: true 

    # Anonymous Service Locator
    Sco\MessageBus\Bus:
      arguments:
        $container: !service_locator
                        '@FindPostByIdHandler': 'handler_one'
                        '@SavePostHandler': 'handler_two'
```

Explicit service locator definition:
```yaml
services:
    _defaults:
      autowire: true      
      autoconfigure: true 

    # Explicit Service Locator
    message_handler_service_locator:
      class: Symfony\Component\DependencyInjection\ServiceLocator
      arguments:
          - '@FindPostByIdHandler'
          - '@SavePostHandler' 

    Sco\MessageBus\Bus:
      arguments:
        $container: '@message_handler_service_locator'
```

Let's expand these configurations and use the tags feature of Symfony's service container to automatically add handlers to the Bus:

Using `!tagged_locator`:
```yaml
services:
  _defaults:
    autowire: true
    autoconfigure: true
    
  _instanceof: 
    Sco\MessageBus\Handler:
      tags: ['message_handler']

  # Anonymous Service Locator
  Sco\MessageBus\Bus:
    arguments:
      $container: !tagged_locator message_handler
```

Explicit service locator definition:
```yaml
services:
  _defaults:
    autowire: true
    autoconfigure: true

  _instanceof:
    Sco\MessageBus\Handler:
      tags: ['message_handler']
      
  # Explicit Service Locator
  message_handler_service_locator:
    class: Symfony\Component\DependencyInjection\ServiceLocator
    arguments:
      - !tagged_iterator message_handler

  Sco\MessageBus\Bus:
    arguments:
      $container: '@message_handler_service_locator'
```

### Using with Laravel Framework
To use it effectively with Laravel framework all you have to do is register the Bus in [Laravel's Service Container](https://laravel.com/docs/9.x/container) and provide the container as an argument to the library's Bus class:
```php
$this->app->bind(\Sco\MessageBus\Bus::class, function ($app) {
    return new \Sco\MessageBus\Bus($app);
});
```

## Core Concepts

### Identity
Each _Command_ or _Query_ and their respective _Result_ object combo will be assigned a unique Identity, e.g. a _Command,_ and its respective _Result_ object will have and identity of `00000001`. 
This can be useful for logging, auditing or debugging purposes. 

The default Identity generation strategy is a simple `Sco\MessageBus\Identity\RandomString` generator to keep the external dependencies to a minimum. To use something else you could require a library like https://github.com/ramsey/uuid and implement the `\Sco\MessageBus\Identity`.

```php
use Sco\MessageBus\Identity;

class UuidIdentity implements Identity
{
    public function generate() : string
    {
        return Uuid::uuid7()->toString();
    }
}
```

### Handler Mapping Strategy
1. **MapByName** - this strategy takes into account the [FQN](https://www.php.net/manual/en/language.namespaces.rules.php) and requires a _Command_ or _Query_ suffix in the class name. 
For example an `FindPostByIdQuery` will get mapped to `FindPostByIdHandler` or a `SavePostCommand` will get mapped to `SavePostHandler`.
2. **MapByAttribute** - this strategy uses PHP attributes, add either `#[IsCommand(handler: SavePostHandler::class)]` or `#[IsQuery(handler: FindPostByIdHandler::class)]` to your Command/Query class. The `handler` parameter name can be omitted, it's up to your personal preference.
3. **Custom** - if you want to create your own custom mapping strategy you can do so by implementing the `Sco\MessageBus\Mapper` interface.

### Middleware
Each command will be passed through a chain of Middlewares. By default the chain is empty, but the library does offer 
some Middleware out of the box:
* **EventMiddleware** - raises events before and after handling a command or query, and on failure
* **TransactionMiddleware** - runs individual _Commands_ or _Queries_ in a Transaction, `begin`, `commit` and `rollback` steps are plain `\Closure` objects, so you can use whichever ORM or Persistence approach you prefer. 
* **EmptyResultMiddleware** - throws an Exception if anything aside from null is returned in _Command_ Results to enforce the _Command-Query Segregation_
* **ImmutableResultMiddleware** - throws an Exception if you have properties without _readonly_ modifier defined on your Result objects

To create your own custom middleware you need to implement the `Sco\MessageBus\Middleware` interface and provide it
to the bus:

```php
use Sco\MessageBus\Bus;
use Sco\MessageBus\Message;
use Sco\MessageBus\Middleware;

class CustomMiddleware implements Middleware
{
    public function __invoke(Message $message,\Closure $next) : mixed
    {
        // Do something before message handling
        
        $result = $next($message);
        
        // Do something after message handling
        
        return $result;
    }
}

$bus = new Bus(middlewares: [new CustomMiddleware()]);
```

### Event
If you add the `Sco\MessageBus\Middleware\EventMiddleware` you will be able to subscribe to the following events:

**MessageReceivedEvent** - raised when the message is received but before being handled.
```php
use Sco\MessageBus\Event\Subscriber;
use Sco\MessageBus\Event\MessageReceivedEvent;

$subscriber = new Subscriber();

$subscriber->addListener(MessageReceivedEvent::class, function (MessageReceivedEvent $event) {
  $event->getName(); // Name of the Event
  $event->getMessage();; // Command or Query that has been received
});
```

**MessageHandledEvent** - raised after the message has been handled successfully.

```php
use Sco\MessageBus\Event\Subscriber;
use Sco\MessageBus\Event\MessageHandledEvent;

$subscriber = new Subscriber();

$subscriber->addListener(MessageHandledEvent::class, function (MessageHandledEvent $event) {
    $event->getName(); // Name of the Event
    $event->getMessage(); // Command or Query being handled
    $event->getResult(); // Result for the handled message
});
```

**MessageFailedEvent** - raised when the message handling fails and an exception gets thrown.
```php
use Sco\MessageBus\Event\Subscriber;
use Sco\MessageBus\Event\MessageFailedEvent;

$subscriber = new Subscriber();

$subscriber->addListener(MessageFailedEvent::class, function (MessageFailedEvent $event) {
    $event->getName(); // Name of the Event
    $event->getMessage(); // Command or Query being handled
    $event->getError(); // Captured Exception
});
```

### Transaction

Transaction Middleware accepts three function arguments, each for every stage of the transaction: begin, commit, and rollback. 
Going with this approach allows you to use any ORM you prefer or even using the native \PDO object to interact with your persistence layer.
```php
$pdo = new \PDO('{connection_dsn}')

$transaction = new \Sco\MessageBus\Middleware\TransactionMiddleware(
    fn(): bool => $pdo->beginTransaction(),
    fn(): bool => $pdo->commit(),
    fn(\Throwable $error): bool => $pdo->rollBack(),
);
```

### Result Types

Library wraps the Handler return values into __Result value objects__ to provide a consistent API and so that you can
depend on the return values always being of the same type.

All Result value objects extend the `Sco\MessageBus\Result` abstract class and can be divided into 3 groups:
1. The ones which wrap primitive values:
   * `Sco\MessageBus\Result\Boolean`
   * `Sco\MessageBus\Result\Integer`
   * `Sco\MessageBus\Result\Numeric`
   * `Sco\MessageBus\Result\Text`
   * `Sco\MessageBus\Result\None` (wraps null values)
2. `Sco\MessageBus\Result\Delegated` which wraps objects and delegates calls to properties and methods to the underlying object
3. `Sco\MessageBus\Result\Collection` and `Sco\MessageBus\Result\Map` which wrap number indexed arrays (lists) and string indexed arrays (maps) and implement `\Countable`, `\ArrayAccess` and `\IteratorAggregate` interfaces

You can also add your own custom Result value objects by extending the abstract class `Sco\MessageBus\Result` and returning them in the appropriate handler.

## Contribute

### Style Guide
Library follows the [PSR-12 standard](https://www.php-fig.org/psr/psr-12/).

### TO DO:
1. Add PSR Cache interface and implementation for caching Results
