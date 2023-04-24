<?php

namespace App\Services\Notification;

use App\Services\Notification\Dto\NotifierDto;
use App\Services\Notification\Exceptions\NotifierException;

interface NotifierInterface
{
    /**
     * @param NotifierDto $dto
     * @throws NotifierException
     * @return void
     */
    public function notify(NotifierDto $dto): void;
}