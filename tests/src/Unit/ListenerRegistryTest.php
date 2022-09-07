<?php

declare(strict_types=1);

namespace Spiral\League\Event\Tests\Unit;

use League\Event\OneTimeListener;
use League\Event\PrioritizedListenerRegistry;
use PHPUnit\Framework\TestCase;
use Spiral\League\Event\ListenerRegistry;
use Spiral\League\Event\Tests\App\Event\UserWasCreated;
use Spiral\League\Event\Tests\App\Subscriber\CustomSubscriber;

final class ListenerRegistryTest extends TestCase
{
    private ListenerRegistry $registry;

    protected function setUp(): void
    {
        $this->registry = new ListenerRegistry(new PrioritizedListenerRegistry());
    }

    public function testAddListener(): void
    {
        $this->registry->addListener(UserWasCreated::class, static fn () => 'first', 1);
        $this->registry->addListener(UserWasCreated::class, static fn () => 'second');

        $events = \iterator_to_array($this->registry->getListenersForEvent(new UserWasCreated()));
        $this->assertCount(2, $events);
        $this->assertSame('first', $events[0]());
        $this->assertSame('second', $events[1]());
    }

    public function testAddOneTimeListener(): void
    {
        $this->registry->addOneTimeListener(UserWasCreated::class, static fn () => null);

        $events = \iterator_to_array($this->registry->getListenersForEvent(new UserWasCreated()));
        $this->assertCount(1, $events);

        $this->assertInstanceOf(OneTimeListener::class, $events[0]);
    }

    public function testAddListenersFrom(): void
    {
        $this->registry->addListenersFrom(new CustomSubscriber());

        $events = \iterator_to_array($this->registry->getListenersForEvent(new UserWasCreated()));
        $this->assertCount(1, $events);
        $this->assertSame('subscribed', $events[0]());
    }
}
