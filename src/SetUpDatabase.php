<?php declare(strict_types=1);

namespace BankApp;

use BankApp\Persistence\DatabaseClient;

final class SetUpDatabase
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

        $this->databaseClient->rawSql(
            'CREATE TABLE customers (
                firstName varchar(100), 
                lastName varchar(100), 
                gender varchar(100), 
                country varchar(100), 
                email varchar(100), 
                bonus int(3)
            )'
        );
    }
}