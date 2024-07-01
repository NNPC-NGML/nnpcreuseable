<?php

namespace Skillz\Nnpcreusable\Service;

use Skillz\Nnpcreusable\Models\Customer;
use Skillz\Nnpcreusable\Models\CustomerSite;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;


class CustomerService
{

    /**
     * Get a customer by its ID.
     *
     * @param int $id
     * @return Customer|null
     */
    public function showCustomer(int $id): ?Customer
    {
        return Customer::findOrFail($id);
    }

    /**
     * Create a new customer.
     *
     * @param array $request
     * @return Task|null
     */
    public function createCustomer(array $request): ?Customer
    {
        $customer = Customer::create($request);
        return $customer;
    }

    /**
     * Update an existing customer.
     *
     * @param array $request
     * @param int $id
     * @return bool|null
     */
    public function updateCustomer(array $request, int $id): ?bool
    {
        $customer = Customer::findOrFail($id);
        return $customer->update($request);
    }

    /**
     * Delete a customer.
     *
     * @param int $id
     * @return bool
     */
    public function destroyCustomer(int $id): bool
    {
        $customer = $this->showCustomer($id);
        return $customer->delete();
    }


    /**
     * Get a customer by its ID.
     *
     * @param int $id
     * @return Customer|null
     */
    public function showCustomerSite(int $id): ?CustomerSite
    {
        return CustomerSite::findOrFail($id);
    }

    /**
     * Create a new customer.
     *
     * @param array $request
     * @return Task|null
     */
    public function createCustomerSite(array $request): ?CustomerSite
    {
        $customerSite = CustomerSite::create($request);
        return $customerSite;
    }

    /**
     * Update an existing customer.
     *
     * @param array $request
     * @param int $id
     * @return bool|null
     */
    public function updateCustomerSite(array $request, int $id): ?bool
    {
        $customerSite = CustomerSite::findOrFail($id);
        return $customerSite->update($request);
    }

    /**
     * Delete a customer.
     *
     * @param int $id
     * @return bool
     */
    public function destroyCustomerSite(int $id): bool
    {
        $customerSite = $this->showCustomerSite($id);
        return $customerSite->delete();
    }
}
