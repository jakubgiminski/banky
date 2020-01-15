<?php declare(strict_types=1);

namespace BankyFramework\Routing;

class Route
{
    private string $method;

    private string $uri;

    private RequestClassName $requestClassName;

    private ControllerClassName $controllerClassName;

    public function __construct(
        string $method,
        string $uri,
        RequestClassName $requestClassName,
        ControllerClassName $controllerClassName
    ) {
        $this->method = $method;
        $this->uri = $uri;
        $this->requestClassName = $requestClassName;
        $this->controllerClassName = $controllerClassName;
    }

    public function getMethod() : string
    {
        return $this->method;
    }

    public function getUri() : string
    {
        return $this->uri;
    }

    public function getRequestClassName() : RequestClassName
    {
        return $this->requestClassName;
    }

    public function getControllerClassName() : ControllerClassName
    {
        return $this->controllerClassName;
    }
}