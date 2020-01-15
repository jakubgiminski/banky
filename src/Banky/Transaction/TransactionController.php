<?php declare(strict_types=1);

namespace Banky\Transaction;

use Banky\Customer\CustomerDoesNotExistsException;
use Banky\Customer\CustomerId;
use Banky\Customer\CustomerRepository;

abstract class TransactionController
{
    protected CustomerRepository $customerRepository;

    protected TransactionRepository $transactionRepository;

    public function __construct(CustomerRepository $customerRepository, TransactionRepository $transactionRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->transactionRepository = $transactionRepository;
    }

    protected function customerMustExist(CustomerId $customerId) : void
    {
        if ($this->customerRepository->customerWithIdExists($customerId) === false) {
            throw new CustomerDoesNotExistsException($customerId);
        }
    }
}