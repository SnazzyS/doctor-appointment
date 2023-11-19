<?php

namespace App\Actions\Customers;

use App\Models\Customer;

class CustomerShowAction
{

    public function execute()
    {
        $customers = Customer::get(['name', 'phone_number', 'id_card_number']);
        
        return $customers;
    }
}
