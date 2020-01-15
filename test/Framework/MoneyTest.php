<?php declare(strict_types=1);

namespace BankyFrameworkTest;

use Banky\Transaction\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    /** @test */
    public function roundLongFloat() : void
    {
        self::assertSame(
            33.44,
            (new Money(33.44222111))->getValue()
        );

        self::assertSame(
            -33.44,
            (new Money(-33.44222111))->getValue()
        );
    }
}