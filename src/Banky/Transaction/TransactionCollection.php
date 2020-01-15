<?php declare(strict_types=1);

namespace Banky\Transaction;

use Comquer\Collection\Collection;
use Comquer\Collection\Type;
use Comquer\Collection\UniqueIndex;

class TransactionCollection extends Collection
{
    public function __construct(array $transactions = [])
    {
        parent::__construct(
            $transactions,
            Type::object(Transaction::class),
            new UniqueIndex(function (Transaction $transaction) : string {
                return (string) $transaction->getId();
            })
        );
    }
}