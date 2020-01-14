<?php

use BankApp\BootstrapContainer;
use BankApp\Customer\RegisterCustomer\RegisterCustomerRequest;
use BankApp\Customer\RegisterCustomerController;
use BankApp\Http\InvalidRequestException;
use BankApp\Http\InvalidRequestResponse;

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

    $response = $controller($request);

    return $response->serialize();
});

$router->run();
