<?php

namespace App\Services\Notification\Notifiers;

use App\Services\Notification\Dto\NotifierDto;
use App\Services\Notification\Exceptions\NotifierException;
use App\Services\Notification\NotifierInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailNotifier implements NotifierInterface
{
    public function __construct(
        private readonly MailerInterface $mailer
    ) {
    }

    public function notify(NotifierDto $dto): void
    {
        try {
            $this->mailer->send($this->createMail($dto));
        } catch (TransportExceptionInterface $exception) {
            new NotifierException($exception->getMessage(), $exception->getCode());
        }
    }

    private function createMail(NotifierDto $dto): Email
    {
        $email = (new Email())
            ->to($dto->to)
            ->text($dto->message)
            ->from($dto->from);

        if (!empty($dto->subject)) {
            $email->subject($dto->subject);
        }

        return $email;
    }
}
