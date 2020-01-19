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
                id varchar(36) NOT NULL,
                firstName varchar(100) NOT NULL,
                lastName varchar(100) NOT NULL,
                gender varchar(100) NOT NULL,
                country varchar(2) NOT NULL,
                email varchar(100) NOT NULL UNIQUE,
                bonus int(3) NOT NULL,
                PRIMARY KEY (email)
            )"
        );

        $transactionsTable = TransactionRepository::TABLE;
        $this->databaseClient->rawSql(
            "CREATE TABLE $transactionsTable (
                id varchar(36) NOT NULL,
                amount double(100, 2) NOT NULL,
                balanceAfterwards double(100, 2) NOT NULL,
                customerId varchar(36) NOT NULL,
                timestamp double(20, 4) NOT NULL,
                bonus double(100, 2) NOT NULL,
                PRIMARY KEY (id)
            )"
        );
    }
}