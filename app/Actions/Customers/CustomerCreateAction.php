<?php

namespace App\Actions\Customers;

use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CustomerCreateAction
{
    public function execute($data)
    {
        $validator = Validator::make($data, [
            'name' => ['required', 'regex:/^[a-zA-Z\s]*$/'],
            'phone_number' => 'integer|required',
            'id_card_number' => ['required', 'regex:/^A\d{6}$/'],
        ]);
        
        if($validator->fails()) {
            throw new ValidationException($validator);
        }

        $customer = Customer::create($validator->validated());

        return $customer;
        
    }
}
