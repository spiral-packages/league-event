# The League Event bridge for Spiral Framework

[![PHP](https://img.shields.io/packagist/php-v/spiral-packages/league-event.svg?style=flat-square)](https://packagist.org/packages/spiral-packages/league-event)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/spiral-packages/league-event.svg?style=flat-square)](https://packagist.org/packages/spiral-packages/league-event)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spiral-packages/league-event/run-tests?label=tests&style=flat-square)](https://github.com/spiral-packages/league-event/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/spiral-packages/league-event.svg?style=flat-square)](https://packagist.org/packages/spiral-packages/league-event)

## Requirements

Make sure that your server is configured with following PHP version and extensions:

- PHP 8.1+
- Spiral framework 3.0+

## Installation

You can install the package via composer:

```bash
composer require spiral-packages/league-event
```

After package install you need to register bootloader from the package.

```php
protected const LOAD = [
    // ...
    \Spiral\League\Event\Bootloader\EventBootloader::class,
];
```

> **Note**
> If you are using [`spiral-packages/discoverer`](https://github.com/spiral-packages/discoverer),
> you don't need to register bootloader by yourself.

## Usage

### Event

An event can be represented by a simple class:

```php
namespace Spiral\Router\Event;

use Spiral\Router\RouteInterface;

final class RouteFound
{
    public function __construct(
        public readonly RouteInterface $route
    ) {
    }
}
```

#### Dispatching an event:

```php
$this->container->get(EventDispatcherInterface::class)->dispatch(new RouteNotFound($request));
```

### Listener

A listener can be represented by a simple class with a method that will be called to handle the event.
The method name can be configured in the Listener attribute parameter or in the configuration file (` __invoke` by default):

```php
namespace App\Listener;

use Spiral\Events\Attribute\Listener;
use Spiral\Router\Event\RouteFound;

class RouteListener
{
    public function __invoke(RouteFound $event): void
    {
        // ...
    }
}
```

#### Registering a listener via a config file:

```php

// file app/config/events.php

use App\Listener\RouteListener;
use Spiral\Events\Config\EventListener;
use Spiral\Router\Event\RouteFound;

return [
    'listeners' => [
        // without any options
        RouteFound::class => [
            RouteListener::class,
        ],

        // OR

        // with additional options
        RouteFound::class => [
            new EventListener(
                listener: RouteListener::class,
                method: 'onRouteFound',
                priority: 1
            ),
        ],
    ]
];
```

#### Registering a listener via an attribute:

The attribute can be used without additional parameters. Then the method name __invoke and the event from the type of the method parameter will be used:

```php
namespace App\Listener;

use Spiral\Events\Attribute\Listener;
use Spiral\Router\Event\RouteFound;

#[Listener]
class RouteListener
{
    public function __invoke(RouteFound $event): void
    {
        // ...
    }
}
```

All available options:

```php
namespace App\Listener;

use Spiral\Events\Attribute\Listener;
use Spiral\Router\Event\RouteFound;

#[Listener(event: RouteFound::class, method: 'onRouteFound', priority: 1)]
class RouteListener
{
    public function onRouteFound(RouteFound $event): void
    {
        // ...
    }
}
```

The attribute can be used directly on the method, then the method name can be omitted:

```php
namespace App\Listener;

use Spiral\Events\Attribute\Listener;
use Spiral\Router\Event\RouteFound;

class RouteListener
{
    #[Listener(priority: 1)]
    public function onRouteFound(RouteFound $event): void
    {
        // ...
    }
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [butschster](https://github.com/spiral-packages)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
