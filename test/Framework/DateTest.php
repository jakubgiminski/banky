<?php declare(strict_types=1);

namespace BankyFrameworkTest;

use BankyFramework\Date;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class DateTest extends TestCase
{
    /** @test */
    public function daysAgo() : void
    {
        self::assertSame(
            (new DateTimeImmutable('5 days ago'))->format('Y-m-d'),
            (string) Date::daysAgo(5)
        );
    }
}