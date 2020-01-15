<?php declare(strict_types=1);

namespace BankyFramework\Http;

use Throwable;

class ErrorResponse extends Response
{
    public static function fromException(Throwable $exception) : self
    {
        return new self($exception->getCode() ?: 500, [$exception->getMessage()]);
    }
}