<?php declare(strict_types=1);

namespace BankyFramework;

use DateInterval;
use DateTimeImmutable;

class Date
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function daysAgo(int $numberOfDays = 0) : self
    {
        $dateInterval = new DateInterval("P0Y{$numberOfDays}DT0H0M");
        $dateTime = (new DateTimeImmutable)->sub($dateInterval);
        $date = $dateTime->format('Y-m-d');

        return new self($date);
    }

    public function getFirstSecondTimestamp() : float
    {
        return (float) (new DateTimeImmutable($this->value))
            ->setTime(0, 0, 0, 0)
            ->getTimestamp();
    }

    public function getLastSecondTimestamp() : float
    {
        return (float) (new DateTimeImmutable($this->value))
            ->setTime(23, 59, 59, 9999)
            ->getTimestamp();
    }

    public function __toString() : string
    {
        return $this->value;
    }
}