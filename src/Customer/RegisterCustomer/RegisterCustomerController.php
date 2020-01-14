<?php declare(strict_types=1);

namespace BankApp\Customer\RegisterCustomer;

use BankApp\Customer\Customer;
use BankApp\Customer\CustomerRepository;

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