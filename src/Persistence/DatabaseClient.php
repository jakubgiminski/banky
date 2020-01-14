<?php declare(strict_types=1);

namespace BankApp\Persistence;

interface DatabaseClient
{
    public function fetch(string $tableName, array $query) : array;

    public function insert(string $tableName, array $record) : void;

    public function rawSql(string $sql);
}