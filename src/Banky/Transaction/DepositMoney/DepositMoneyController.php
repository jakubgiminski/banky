<?php declare(strict_types=1);

namespace Banky\Transaction\DepositMoney;

use Banky\Customer\CustomerId;
use Banky\Customer\CustomerRepository;
use Banky\Transaction\BonusCalculator;
use Banky\Transaction\Transaction;
use Banky\Transaction\TransactionController;
use Banky\Transaction\TransactionId;
use Banky\Transaction\TransactionRepository;
use BankyFramework\Http\CreateResourceResponse;
use Banky\Transaction\Money;

class DepositMoneyController extends TransactionController
{
    private BonusCalculator $bonusCalculator;

    public function __construct(
        CustomerRepository $customerRepository,
        TransactionRepository $transactionRepository,
        BonusCalculator $bonusCalculator
    ) {
        parent::__construct($customerRepository, $transactionRepository);
        $this->bonusCalculator = $bonusCalculator;
    }

    public function __invoke(DepositMoneyRequest $request) : CreateResourceResponse
    {
        $customerId = new CustomerId($request->getParameter('customerId'));
        $this->customerMustExist($customerId);

        $depositAmount = new Money((float) $request->getParameter('amount'));
        $currentBalance = $this->transactionRepository->getBalance($customerId);

        $transaction = new Transaction(
            TransactionId::generate(),
            $depositAmount,
            $currentBalance->add($depositAmount),
            $customerId,
            microtime(true),
            ($this->bonusCalculator)($customerId, $depositAmount)
        );

        $this->transactionRepository->save($transaction);

        return CreateResourceResponse::fromResource($transaction->serialize());
    }
}