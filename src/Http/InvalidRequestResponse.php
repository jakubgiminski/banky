<?php declare(strict_types=1);

namespace BankApp\Http;

class InvalidRequestResponse extends Response
{
    public static function fromException(InvalidRequestException $exception) : self
    {
        return new self($exception->getCode(), $exception->getErrors());
    }
}