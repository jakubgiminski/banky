<?php declare(strict_types=1);

namespace BankyFramework\Persistence\MySql;

use RuntimeException;

class MySqlClientException extends RuntimeException
{
    public function __construct(string $error)
    {
        parent::__construct($error);
    }
}