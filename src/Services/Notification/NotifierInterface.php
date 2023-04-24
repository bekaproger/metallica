<?php

namespace App\Services\Notification;

use App\Services\Notification\Dto\NotifierDto;
use App\Services\Notification\Exceptions\NotifierException;

interface NotifierInterface
{
    /**
     * @throws NotifierException
     */
    public function notify(NotifierDto $dto): void;
}
