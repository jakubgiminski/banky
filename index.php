<?php

use BankApp\BootstrapContainer;
use BankApp\Customer\RegisterCustomer\RegisterCustomerController;
use BankApp\Customer\RegisterCustomer\RegisterCustomerRequest;
use BankApp\Http\InvalidRequestException;
use BankApp\Http\InvalidRequestResponse;
use BankApp\Http\Response;

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
