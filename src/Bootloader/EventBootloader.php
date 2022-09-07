<?php

declare(strict_types=1);

namespace Spiral\League\Event\Bootloader;

use League\Event\EventDispatcher;
use Psr\EventDispatcher\EventDispatcherInterface;
use Spiral\Boot\Bootloader\Bootloader;
use Spiral\Events\Bootloader\EventsBootloader;
use Spiral\Events\ListenerRegistryInterface as SpiralListenerRegistryInterface;
use Spiral\League\Event\ListenerRegistry;
use Spiral\League\Event\ListenerRegistryInterface;

final class EventBootloader extends Bootloader
{
    protected const DEPENDENCIES = [
        EventsBootloader::class
    ];

    protected const SINGLETONS = [
        SpiralListenerRegistryInterface::class => ListenerRegistryInterface::class,
        ListenerRegistryInterface::class => ListenerRegistry::class,
        ListenerRegistry::class => ListenerRegistry::class,
        EventDispatcherInterface::class => [self::class, 'initDispatcher'],
        EventDispatcher::class => EventDispatcherInterface::class
    ];

    private function initDispatcher(ListenerRegistry $registry): EventDispatcher
    {
        return new EventDispatcher($registry);
    }
}
