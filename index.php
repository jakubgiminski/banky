<?php

use Banky\BootstrapContainer;
use Banky\Customer\RegisterCustomer\RegisterCustomerController;
use Banky\Customer\RegisterCustomer\RegisterCustomerRequest;
use BankyFramework\Http\InvalidRequestException;
use BankyFramework\Http\InvalidRequestResponse;
use BankyFramework\Http\Response;

require 'vendor/autoload.php';

$container = (new BootstrapContainer())();

$router = new Buki\Router();

$router->get('/', function() {
    return 'Bank App';
});

$controller = $container->get(RegisterCustomerController::class);
$router->post('/customers', function () use ($controller) {
    try {
        $request = new RegisterCustomerRequest($_POST);
        $request();
    } catch (InvalidRequestException $exception) {
        return InvalidRequestResponse::fromException($exception)->serialize();
    }

    try {
        /** @var Response $response */
        $response = $controller($request);
    } catch (Throwable $exception) {
        return json_encode([
            'code' => 500,
            'message' => $exception->getMessage(),
        ]);
    }

    return $response->serialize();
});

$router->run();
