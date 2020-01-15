<?php declare(strict_types=1);

namespace BankyFramework\Http;

abstract class Response
{
    private int $code;

    private array $message;

    public function __construct(int $code, array $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    public function serialize() : string
    {
        return json_encode([
            'code' => $this->code,
            'message' => $this->message,
        ]);
    }
}