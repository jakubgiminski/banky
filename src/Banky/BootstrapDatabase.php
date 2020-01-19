<?php declare(strict_types=1);

namespace Banky;

use Banky\Customer\CustomerRepository;
use Banky\Transaction\TransactionRepository;
use BankyFramework\Persistence\DatabaseClient;

final class BootstrapDatabase
{
    private DatabaseClient $databaseClient;

    public function __construct(DatabaseClient $databaseClient)
    {
        $this->databaseClient = $databaseClient;
    }

    public function __invoke(string $databaseName) : void
    {
        $this->databaseClient->rawSql("DROP DATABASE IF EXISTS $databaseName;");
        $this->databaseClient->rawSql("CREATE DATABASE $databaseName;");
        $this->databaseClient->rawSql("USE $databaseName;");

        $customersTable = CustomerRepository::TABLE;
        $this->databaseClient->rawSql(
            "CREATE TABLE $customersTable (
                id varchar(36),
                firstName varchar(100),
                lastName varchar(100),
                gender varchar(100),
                country varchar(2),
                email varchar(100),
                bonus int(3)
            )"
        );

        $transactionsTable = TransactionRepository::TABLE;
        $this->databaseClient->rawSql(
            "CREATE TABLE $transactionsTable (
                id varchar(36),
                amount double(100, 2),
                balanceAfterwards double(100, 2),
                customerId varchar(36),
                timestamp double(20, 4),
                bonus double(100, 2)
            )"
        );
    }
}