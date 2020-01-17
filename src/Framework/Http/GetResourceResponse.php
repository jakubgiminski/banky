<?php declare(strict_types=1);

namespace BankyFramework\Http;

class GetResourceResponse extends Response
{
    public static function fromResource(array $resource) : self
    {
        return new self(200, $resource);
    }
}