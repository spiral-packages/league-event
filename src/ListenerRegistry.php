<?php

declare(strict_types=1);

namespace Spiral\League\Event;

use League\Event\ListenerSubscriber;
use League\Event\PrioritizedListenerRegistry;
use Psr\EventDispatcher\ListenerProviderInterface;

final class ListenerRegistry implements ListenerRegistryInterface, ListenerProviderInterface
{
    public function __construct(
        private readonly PrioritizedListenerRegistry $registry
    ) {
    }

    public function addListener(string $event, callable $listener, int $priority = 0): void
    {
        $this->registry->subscribeTo($event, $listener, $priority);
    }

    public function addOneTimeListener(string $event, callable $listener, int $priority = 0): void
    {
        $this->registry->subscribeOnceTo($event, $listener, $priority);
    }

    public function getListenersForEvent(object $event): iterable
    {
        return $this->registry->getListenersForEvent($event);
    }

    public function addListenersFrom(ListenerSubscriber $subscriber): void
    {
        $this->registry->subscribeListenersFrom($subscriber);
    }
}
