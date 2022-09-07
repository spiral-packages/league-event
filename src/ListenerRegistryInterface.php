<?php

declare(strict_types=1);

namespace Spiral\League\Event;

use League\Event\ListenerSubscriber;
use Spiral\Events\ListenerRegistryInterface as SpiralListenerRegistryInterface;

interface ListenerRegistryInterface extends SpiralListenerRegistryInterface
{
    public function addOneTimeListener(string $event, callable $listener, int $priority = 0): void;

    public function addListenersFrom(ListenerSubscriber $subscriber): void;
}
