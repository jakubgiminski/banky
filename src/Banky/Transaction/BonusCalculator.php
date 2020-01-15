<?php declare(strict_types=1);

namespace Banky\Transaction;

use Banky\Customer\CustomerId;
use Banky\Customer\CustomerRepository;
use BankyFramework\Money;

final class BonusCalculator
{
    private CustomerRepository $customerRepository;

    private TransactionRepository $transactionRepository;

    public function __construct(CustomerRepository $customerRepository, TransactionRepository $transactionRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function __invoke(CustomerId $customerId, Money $deposited) : Money
    {
        if ($this->isCustomerEligibleForBonus($customerId) === false) {
            return new Money(0);
        }
        $bonus = $this->customerRepository->getBonusMultiplier($customerId);

        return $deposited->multiplyBy($bonus);
    }

    private function isCustomerEligibleForBonus(CustomerId $customerId) : bool
    {
        $latestDeposits = $this->transactionRepository->getLatestDeposits($customerId, 2);

        if ($latestDeposits->count() < 2) {
            return false;
        }

        /** @var Transaction $deposit */
        foreach ($latestDeposits as $deposit) {
            if ($deposit->getBonus()->getValue() !== 0) {
                return false;
            }
        }

        return true;
    }
}