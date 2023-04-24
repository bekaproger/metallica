<?php

namespace App\Services\Notification\Dto;

class NotifierDto
{
    public function __construct(
        public readonly mixed $to,
        public readonly string $message,
        public readonly string $from,
        public readonly ?string $subject = null,
    ) {
    }
}