<?php

namespace App\Services\FinanceService\Entity;

use Symfony\Component\Serializer\Annotation\Ignore;

class Price
{
    public const DATE_FORMAT = 'Y-m-d H:i';

    private string $formattedDate;

    public function __construct(
        #[Ignore]
        private \DateTimeInterface $date,
        private float $open,
        private float $high,
        private float $low,
        private float $close,
        private int $volume
    ) {
        $this->formattedDate = $this->date->format(self::DATE_FORMAT);
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): void
    {
        $this->date = $date;
        $this->formattedDate = $this->date->format('Y-m-d');
    }

    public function getOpen(): float
    {
        return $this->open;
    }

    public function setOpen(float $open): void
    {
        $this->open = $open;
    }

    public function getHigh(): float
    {
        return $this->high;
    }

    public function setHigh(float $high): void
    {
        $this->high = $high;
    }

    public function getLow(): float
    {
        return $this->low;
    }

    public function setLow(float $low): void
    {
        $this->low = $low;
    }

    public function getClose(): float
    {
        return $this->close;
    }

    public function setClose(float $close): void
    {
        $this->close = $close;
    }

    public function getVolume(): int
    {
        return $this->volume;
    }

    public function setVolume(int $volume): void
    {
        $this->volume = $volume;
    }

    public function getFormattedDate(): string
    {
        return $this->formattedDate;
    }
}
