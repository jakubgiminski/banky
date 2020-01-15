<?php declare(strict_types=1);

namespace Banky\Transaction\DepositMoney;

use Banky\Customer\CustomerId;
use Banky\Transaction\Transaction;
use Banky\Transaction\TransactionId;
use Banky\Transaction\TransactionRepository;
use BankyFramework\Http\CreateResourceResponse;
use BankyFramework\Money;
use DateTimeImmutable;

class DepositMoneyController
{
    private TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function __invoke(DepositMoneyRequest $request) : CreateResourceResponse
    {
        $transaction = new Transaction(
            TransactionId::generate(),
            new Money((float) $request->getParameter('amount')),
            new CustomerId($request->getParameter('customerId')),
            (new DateTimeImmutable())->getTimestamp()
        );

        $this->transactionRepository->save($transaction);

        return CreateResourceResponse::fromResource($transaction->serialize());
    }
}