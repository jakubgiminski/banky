<?php declare(strict_types=1);

namespace Banky\Transaction;

use Banky\Customer\CustomerId;
use BankyFramework\Persistence\DatabaseClient;
use mysqli_result;

class TransactionRepository
{
    public const TABLE = 'transactions';

    private DatabaseClient $databaseClient;

    public function __construct(DatabaseClient $databaseClient)
    {
        $this->databaseClient = $databaseClient;
    }

    public function save(Transaction $transaction) : void
    {
        $this->databaseClient->insert(
            self::TABLE,
            $transaction->serialize()
        );
    }

    public function getLatestDeposits(CustomerId $customerId, int $limit) : TransactionCollection
    {
        $table = self::TABLE;
        $results = $this->databaseClient->rawSql("
            SELECT * FROM $table WHERE customerId = '$customerId' AND amount > 0 ORDER BY timestamp DESC LIMIT $limit
        ");

        return $this->hydrateRecords($results);
    }

    public function getBalance(CustomerId $customerId) : Money
    {
        $table = self::TABLE;
        $records = $this->databaseClient->rawSql("
            SELECT * FROM $table WHERE customerId = '$customerId' ORDER BY timestamp DESC LIMIT 1
        ");

        $transactions = $this->hydrateRecords($records);

        /** @var Transaction $lastTransaction */
        $lastTransaction = $transactions->getLast();

        return $transactions->isEmpty() === true
            ? new Money()
            : $lastTransaction->getBalanceAfterwards();
    }

    public function getForPeriod(float $beginning, float $end) : TransactionCollection
    {
        $table = self::TABLE;
        $records = $this->databaseClient->rawSql("
            SELECT * FROM $table WHERE timestamp >= $beginning AND timestamp <= $end
        ");

        return $this->hydrateRecords($records);
    }

    private function hydrateRecords($records) : TransactionCollection
    {
        $transactions = new TransactionCollection();

        if ($records instanceof mysqli_result === false) {
            return $transactions;
        }

        foreach ($records as $record) {
            $transactions->add(Transaction::deserialize($record));
        }

        return $transactions;
    }
}