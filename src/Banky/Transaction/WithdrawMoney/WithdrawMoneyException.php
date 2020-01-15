<?php declare(strict_types=1);

namespace Banky\Transaction\WithdrawMoney;

use Banky\Transaction\Money;
use RuntimeException;

class WithdrawMoneyException extends RuntimeException
{
    public static function insufficientFunds(Money $withdrawalAmount, Money $availableBalance) : self
    {
        return new self("Withdrawal amount `$withdrawalAmount` exceeds available balance `$availableBalance`");
    }
}