<?php declare(strict_types=1);

namespace Banky\Report;

use Banky\Transaction\Money;
use BankyFramework\Date;
use BankyFramework\Serializable;

class Report implements Serializable
{
    private Date $date;

    private int $uniqueCustomers;

    private int $numberOfDeposits;

    private Money $totalDepositAmount;

    private int $numberOfWithdrawals;

    private Money $totalWithdrawalAmount;

    public function __construct(Date $date, int $uniqueCustomers, int $numberOfDeposits, Money $totalDepositAmount, int $numberOfWithdrawals, Money $totalWithdrawalAmount)
    {
        $this->date = $date;
        $this->uniqueCustomers = $uniqueCustomers;
        $this->numberOfDeposits = $numberOfDeposits;
        $this->totalDepositAmount = $totalDepositAmount;
        $this->numberOfWithdrawals = $numberOfWithdrawals;
        $this->totalWithdrawalAmount = $totalWithdrawalAmount;
    }

    public function serialize() : array
    {
        return [
            'date' => (string) $this->date,
            'uniqueCustomers' => $this->uniqueCustomers,
            'numberOfDeposits' => $this->numberOfDeposits,
            'totalDepositAmount' => $this->totalDepositAmount->getValue(),
            'numberOfWithdrawals' => $this->numberOfWithdrawals,
            'totalWithdrawalAmount' => $this->totalWithdrawalAmount->getValue(),
        ];
    }
}