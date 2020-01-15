<?php declare(strict_types=1);

namespace Banky\Transaction\DepositMoney;

use Banky\Customer\CustomerDoesNotExistsException;
use Banky\Customer\CustomerId;
use Banky\Customer\CustomerRepository;
use Banky\Transaction\BonusCalculator;
use Banky\Transaction\Transaction;
use Banky\Transaction\TransactionId;
use Banky\Transaction\TransactionRepository;
use BankyFramework\Http\CreateResourceResponse;
use BankyFramework\Money;
use DateTimeImmutable;

class DepositMoneyController
{
    private CustomerRepository $customerRepository;

    private TransactionRepository $transactionRepository;

    private BonusCalculator $bonusCalculator;

    public function __construct(
        CustomerRepository $customerRepository,
        TransactionRepository $transactionRepository,
        BonusCalculator $bonusCalculator
    ) {
        $this->customerRepository = $customerRepository;
        $this->transactionRepository = $transactionRepository;
        $this->bonusCalculator = $bonusCalculator;
    }

    public function __invoke(DepositMoneyRequest $request) : CreateResourceResponse
    {
        $customerId = new CustomerId($request->getParameter('customerId'));
        $depositedAmount = new Money((float) $request->getParameter('amount'));
        $this->customerMustExist($customerId);

        $transaction = new Transaction(
            TransactionId::generate(),
            $depositedAmount,
            $customerId,
            (new DateTimeImmutable())->getTimestamp(),
            ($this->bonusCalculator)($customerId, $depositedAmount)
        );

        $this->transactionRepository->save($transaction);

        return CreateResourceResponse::fromResource($transaction->serialize());
    }

    private function customerMustExist(CustomerId $customerId) : void
    {
        if ($this->customerRepository->customerWithIdExists($customerId) === false) {
            throw new CustomerDoesNotExistsException($customerId);
        }
    }
}