<?php declare(strict_types=1);

namespace BankApp\Customer;

use BankApp\Customer\RegisterCustomer\RegisterCustomerException;
use BankApp\Customer\RegisterCustomer\RegisterCustomerRequest;
use BankApp\Customer\RegisterCustomer\RegisterCustomerResponse;
use BankApp\Customer\RegisterCustomer\RegistrationBonus;

class RegisterCustomerController
{
    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function __invoke(RegisterCustomerRequest $request) : RegisterCustomerResponse
    {
        $customerEmail = $request->getParameter('email');
        if ($this->customerRepository->exists($customerEmail) === true) {
            throw RegisterCustomerException::customerAlreadyRegistered($customerEmail);
        }

        $customer = new Customer(
            $request->getParameter('firstName'),
            $request->getParameter('lastName'),
            $request->getParameter('gender'),
            $request->getParameter('country'),
            $request->getParameter('email'),
            RegistrationBonus::random()
        );

        $this->customerRepository->persist($customer);

        return RegisterCustomerResponse::fromCustomer($customer);
    }
}