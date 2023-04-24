<?php

namespace App\Services\Notification;

use App\Services\Notification\Dto\NotifierDto;

class NotificationService implements NotificationServiceInterface
{
    public function __construct(
        private readonly NotifierInterface $notifier
    ) {
    }

    public function notify(NotifierDto $dto): void
    {
        $this->notifier->notify($dto);
    }
}
