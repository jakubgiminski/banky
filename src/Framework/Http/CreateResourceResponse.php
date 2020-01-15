<?php declare(strict_types=1);

namespace BankyFramework\Http;

class CreateResourceResponse extends Response
{
    public static function fromResource(array $resource) : self
    {
        return new self(201, $resource);
    }
}