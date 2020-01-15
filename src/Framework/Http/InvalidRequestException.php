<?php declare(strict_types=1);

namespace BankyFramework\Http;

use InvalidArgumentException;

class InvalidRequestException extends InvalidArgumentException
{
    private array $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;

        parent::__construct(
            json_encode($errors),
            422
        );
    }

    public static function fromErrors(array $errors) : self
    {
        return new self($errors);
    }

    public static function forMissingParameter(string $parameterName) : self
    {
        return new self(["Parameter `$parameterName` is not set"]);
    }

    public function getErrors() : array
    {
        return $this->errors;
    }
}