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
            SELECT * FROM $table WHERE customerId = '$customerId' AND amount > 0 ORDER BY CAST(timestamp as UNSIGNED) DESC LIMIT $limit
        ");

        return $this->hydrateResults($results);
    }

    public function getBalance(CustomerId $customerId) : Money
    {
        $table = self::TABLE;
        $results = $this->databaseClient->rawSql("
            SELECT * FROM $table WHERE customerId = '$customerId'
        ");
        $transactions = $this->hydrateResults($results);

        return $transactions->calculateBalance();
    }

    private function hydrateResults($results) : TransactionCollection
    {
        $transactions = new TransactionCollection();

        if ($results instanceof mysqli_result === false) {
            return $transactions;
        }
        
        foreach ($results as $record) {
            $transactions->add(Transaction::deserialize($record));
        }

        return $transactions;
    }
}