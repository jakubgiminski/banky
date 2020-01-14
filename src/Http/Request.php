<?php declare(strict_types=1);

namespace BankApp\Http;

abstract class Request
{
    private array $payload;

    private array $errors = [];

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function __invoke() : void
    {
        if (empty($this->errors) === false) {
            throw RequestException::fromErrors($this->errors);
        }
    }

    public function getParameter(string $parameterName)
    {
        if (isset($this->payload[$parameterName]) === false) {
            throw RequestException::forMissingParameter($parameterName);
        }

        return $this->payload[$parameterName];
    }

    protected function requireStringParameter(string $parameterName) : void
    {
        $this->requireParameter($parameterName, function ($value) : bool {
            return is_string($value) === true;
        });
    }

    protected function requireEmailParameter(string $parameterName) : void
    {
        $this->requireParameter($parameterName, function ($value) : bool {
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        });
    }

    protected function requireParameter(string $parameterName, callable $isValid) : void
    {
        if (isset($this->payload[$parameterName]) === false) {
            $this->errors[] = "Required parameter `$parameterName` missing";
            return;
        }

        if ($isValid($this->payload[$parameterName]) === false) {
            $this->errors[] = "Invalid value of required parameter `$parameterName`";
        }
    }
}