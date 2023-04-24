<?php

namespace App\Services\FinanceService\Entity;

use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Ignore;

class Price
{
    const DATE_FORMAT = 'Y-m-d H:i';

    private string $formattedDate;

    public function __construct(
        #[Ignore]
        private DateTimeInterface $date,
        private float $open,
        private float $high,
        private float $low,
        private float $close,
        private int $volume
    ) {
        $this->formattedDate = $this->date->format(self::DATE_FORMAT);
    }

    /**
     * @return DateTimeInterface
     */
    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param DateTimeInterface $date
     */
    public function setDate(DateTimeInterface $date): void
    {
        $this->date = $date;
        $this->formattedDate = $this->date->format('Y-m-d');
    }

    /**
     * @return float
     */
    public function getOpen(): float
    {
        return $this->open;
    }

    /**
     * @param float $open
     */
    public function setOpen(float $open): void
    {
        $this->open = $open;
    }

    /**
     * @return float
     */
    public function getHigh(): float
    {
        return $this->high;
    }

    /**
     * @param float $high
     */
    public function setHigh(float $high): void
    {
        $this->high = $high;
    }

    /**
     * @return float
     */
    public function getLow(): float
    {
        return $this->low;
    }

    /**
     * @param float $low
     */
    public function setLow(float $low): void
    {
        $this->low = $low;
    }

    /**
     * @return float
     */
    public function getClose(): float
    {
        return $this->close;
    }

    /**
     * @param float $close
     */
    public function setClose(float $close): void
    {
        $this->close = $close;
    }

    /**
     * @return int
     */
    public function getVolume(): int
    {
        return $this->volume;
    }

    /**
     * @param int $volume
     */
    public function setVolume(int $volume): void
    {
        $this->volume = $volume;
    }

    public function getFormattedDate(): string
    {
        return $this->formattedDate;
    }
}