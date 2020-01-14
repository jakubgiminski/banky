<?php declare(strict_types=1);

namespace BankApp\Http;

use InvalidArgumentException;

class RequestException extends InvalidArgumentException
{
    public static function fromErrors(array $errors) : self
    {
        return new self(json_encode($errors), 422);
    }

    public static function forMissingParameter(string $parameterName) : self
    {
        return new self("Parameter `$parameterName` is not set");
    }
}