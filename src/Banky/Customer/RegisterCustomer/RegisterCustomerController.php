<?php declare(strict_types=1);

namespace Banky\Customer\RegisterCustomer;

use Banky\Customer\Customer;
use Banky\Customer\CustomerId;
use Banky\Customer\CustomerRepository;
use BankyFramework\Http\CreateResourceResponse;

class RegisterCustomerController
{
    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function __invoke(RegisterCustomerRequest $request) : CreateResourceResponse
    {
        $customerEmail = $request->getParameter('email');
        if ($this->customerRepository->customerWithEmailExists($customerEmail) === true) {
            throw RegisterCustomerException::customerAlreadyRegistered($customerEmail);
        }

        $customer = new Customer(
            CustomerId::generate(),
            $request->getParameter('firstName'),
            $request->getParameter('lastName'),
            $request->getParameter('gender'),
            $request->getParameter('country'),
            $request->getParameter('email'),
            RegistrationBonus::random()
        );

        $this->customerRepository->save($customer);

        return CreateResourceResponse::fromResource($customer->serialize());
    }
}