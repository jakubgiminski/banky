<?php declare(strict_types=1);

namespace Banky\Report\GenerateReport;

use Banky\Customer\CustomerIdCollection;
use Banky\Customer\CustomerRepository;
use Banky\Report\Report;
use Banky\Transaction\Money;
use Banky\Transaction\Transaction;
use Banky\Transaction\TransactionRepository;
use BankyFramework\Date;

class ReportGenerator
{
    private CustomerRepository $customerRepository;

    private TransactionRepository $transactionRepository;

    public function __construct(CustomerRepository $customerRepository, TransactionRepository $transactionRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function __invoke(Date $date) : Report
    {
        $transactions = $this->transactionRepository->getForPeriod(
            $date->getFirstSecondTimestamp(),
            $date->getLastSecondTimestamp()
        );

        $uniqueCustomers = new CustomerIdCollection();

        $numberOfDeposits = 0;
        $totalDepositAmount = new Money();

        $numberOfWithdrawals = 0;
        $totalWithdrawalAmount = new Money();

        /** @var Transaction $transaction */
        foreach ($transactions as $transaction) {
            $uniqueCustomers->tryAdding($transaction->getCustomerId());
            if ($transaction->getAmount()->getValue() > 0) {
                $numberOfDeposits++;
                $totalDepositAmount = $totalDepositAmount->add($transaction->getAmount());
                continue;
            }
            $numberOfWithdrawals++;
            $totalWithdrawalAmount = $totalWithdrawalAmount->add($transaction->getAmount());
        }

        return new Report(
            $date,
            $uniqueCustomers->count(),
            $numberOfDeposits,
            $totalDepositAmount,
            $numberOfWithdrawals,
            $totalWithdrawalAmount->revert()
        );
    }
}