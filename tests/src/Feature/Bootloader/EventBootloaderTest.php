<?php

declare(strict_types=1);

namespace Spiral\League\Event\Tests\Feature\Bootloader;

use League\Event\EventDispatcher;
use Psr\EventDispatcher\EventDispatcherInterface;
use Spiral\League\Event\ListenerRegistry;
use Spiral\League\Event\ListenerRegistryInterface;
use Spiral\League\Event\Tests\Feature\TestCase;
use Spiral\Events\ListenerRegistryInterface as SpiralListenerRegistryInterface;

final class EventBootloaderTest extends TestCase
{
    public function testListenerRegistryShouldBeAsSingleton(): void
    {
        $this->assertContainerBoundAsSingleton(SpiralListenerRegistryInterface::class, ListenerRegistry::class);
        $this->assertContainerBoundAsSingleton(ListenerRegistryInterface::class, ListenerRegistry::class);
        $this->assertContainerBoundAsSingleton(ListenerRegistry::class, ListenerRegistry::class);
    }

    public function testEventDispatcherShouldBeAsSingleton(): void
    {
        $this->assertContainerBoundAsSingleton(EventDispatcherInterface::class, EventDispatcher::class);
        $this->assertContainerBoundAsSingleton(EventDispatcher::class, EventDispatcher::class);
    }
}
