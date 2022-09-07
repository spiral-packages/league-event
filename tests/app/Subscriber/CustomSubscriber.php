<?php

declare(strict_types=1);

namespace Spiral\League\Event\Tests\App\Subscriber;

use League\Event\ListenerRegistry;
use League\Event\ListenerSubscriber;
use Spiral\League\Event\Tests\App\Event\UserWasCreated;

final class CustomSubscriber implements ListenerSubscriber
{
    public function subscribeListeners(ListenerRegistry $acceptor): void
    {
        $acceptor->subscribeTo(UserWasCreated::class, static fn () => 'subscribed');
    }
}
