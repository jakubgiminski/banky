<?php declare(strict_types=1);

namespace BankApp\Http;

abstract class Response
{
    private int $code;

    private array $payload;

    public function __construct(int $code, array $payload)
    {
        $this->code = $code;
        $this->payload = $payload;
    }

    public function serialize() : string
    {
        return json_encode([
            'code' => $this->code,
            'payload' => $this->payload,
        ]);
    }
}