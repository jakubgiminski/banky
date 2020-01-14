<?php declare(strict_types=1);

namespace BankApp\Customer;

use Comquer\ArrayValidator\ArrayValidator;

class RegisterCustomer
{
    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function __invoke(array $requestPayload) : Customer
    {
        self::validateRequestPayload($requestPayload);

        $customerEmail = $requestPayload['email'];
        if ($this->customerRepository->exists($customerEmail) === true) {
            throw RegisterCustomerException::customerAlreadyRegistered($customerEmail);
        }

        $customer = new Customer(
            $requestPayload['firstName'],
            $requestPayload['lastName'],
            $requestPayload['gender'],
            $requestPayload['country'],
            $requestPayload['email'],
            rand(1, 100)
        );

        $this->customerRepository->persist($customer);

        return $customer;
    }

    private static function validateRequestPayload(array $requestPayload) : void
    {
        ArrayValidator::validateMultipleKeysExist([
            'firstName',
            'lastName',
            'gender',
            'country',
            'email',
        ], $requestPayload);
    }
}