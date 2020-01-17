<?php declare(strict_types=1);

namespace Banky\Transaction\WithdrawMoney;

use Banky\Customer\CustomerId;
use Banky\Transaction\Money;
use Banky\Transaction\Transaction;
use Banky\Transaction\TransactionController;
use Banky\Transaction\TransactionId;
use BankyFramework\Http\CreateResourceResponse;

class WithdrawMoneyController extends TransactionController
{
    public function __invoke(WithdrawMoneyRequest $request) : CreateResourceResponse
    {
        $customerId = new CustomerId($request->getParameter('customerId'));
        $this->customerMustExist($customerId);

        $withdrawalAmount = new Money((float) $request->getParameter('amount'));
        $currentBalance = $this->transactionRepository->getBalance($customerId);

        if ($withdrawalAmount->isMoreThan($currentBalance) === true) {
            throw WithdrawMoneyException::insufficientFunds($withdrawalAmount, $currentBalance);
        }

        $transaction = new Transaction(
            TransactionId::generate(),
            $withdrawalAmount->revert(),
            $currentBalance->subtract($withdrawalAmount),
            $customerId,
            microtime(true)
        );

        $this->transactionRepository->save($transaction);

        return CreateResourceResponse::fromResource($transaction->serialize());
    }
}