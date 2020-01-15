<?php declare(strict_types=1);

namespace BankyFramework\Routing;

use BankyFramework\Http\ErrorResponse;
use BankyFramework\Http\InvalidRequestException;
use BankyFramework\Http\InvalidRequestResponse;
use BankyFramework\Http\Response;
use Comquer\Collection\Collection;
use Comquer\Collection\Type;
use Comquer\Collection\UniqueIndex;
use Psr\Container\ContainerInterface;
use Throwable;

class Router extends Collection
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct(
            [],
            Type::object(Route::class),
            new UniqueIndex(function (Route $route) {
                return "{$route->getMethod()}:{$route->getUri()}";
            })
        );
    }

    public function registerRoute(string $method, string $uri, string $requestClassName, string $controllerClassName)
    {
        $this->add(
            new Route($method, $uri, new RequestClassName($requestClassName), new ControllerClassName($controllerClassName)
        ));
    }

    public function __invoke() : void
    {
        $route = $this->getRoute($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
        $requestClassName = (string) $route->getRequestClassName();
        $payload = strtoupper($_SERVER['REQUEST_METHOD']) === 'POST' ? $_POST : $_GET;
        $request = new $requestClassName($payload);

        try {
            $request();
        } catch (InvalidRequestException $exception) {
            $this->resolve(InvalidRequestResponse::fromException($exception));
            return;
        }

        $controller = $this->container->get((string) $route->getControllerClassName());

        try {
            $this->resolve($controller($request));
        } catch (Throwable $exception) {
            $this->resolve(ErrorResponse::fromException($exception));
        }
    }

    private function getRoute(string $method, string $uri) : Route
    {
        return $this->get("$method:$uri");
    }

    private function resolve(Response $response) : void
    {
        header('Content-Type: application/json');
        http_response_code($response->getCode());
        echo $response->serialize();
    }
}