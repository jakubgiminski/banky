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

    public function calculateBalance() : Money
    {
        $balance = new Money();

        /** @var Transaction $transaction */
        foreach ($this as $transaction) {
            $balance->add($transaction->getAmount());
        }

        return $balance;
    }

    public function getBalanceAfterLastTransaction() : Money
    {
        $transactions = $this->sortAscending(function (Transaction $transaction) : string {
            return (string) $transaction->getId();
        });

        /** @var Transaction $lastTransaction */
        $lastTransaction = $transactions->getLast();

        return $lastTransaction->getBalanceAfterwards();
    }

    /** @todo refactor out to the parent class */
    public function sortDescending(callable $getParameter) : self
    {
        $elements = $this->getElements();

        usort($elements, function ($element, $nextElement) use ($getParameter) {
            if ($getParameter($element) > $getParameter($nextElement)) {
                return -1;
            }

            if ($getParameter($element) < $getParameter($nextElement)) {
                return 1;
            }

            return 0;
        });

        return new self($elements);
    }

    /** @todo refactor out to the parent class */
    public function sortAscending(callable $getParameter) : self
    {
        return new self(array_reverse($this->sortDescending($getParameter)->getElements()));
    }

    /** @todo refactor out to the parent class */
    public function getLast()
    {
        $elements = $this->getElements();
        return end($elements);
    }
}