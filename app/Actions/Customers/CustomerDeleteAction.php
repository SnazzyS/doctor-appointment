<?php
namespace App\Actions\Customers;

use App\Models\Customer;

class CustomerDeleteAction
{
    public function execute($id)
    {
        $customer = Customer::findOrFail($id);

        $customer->delete();

        return $customer;
    }
}
