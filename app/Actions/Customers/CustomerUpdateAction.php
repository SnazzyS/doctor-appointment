<?php

namespace App\Actions\Customers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CustomerUpdateAction
{
    public function execute($data, $customer)
    {
        $validator = Validator::make($data, [
            'name' => ['regex:/^[a-zA-Z\s]*$/'],
            'phone_number' => 'integer',
            'id_card_number' => ['regex:/^A\d{6}$/'],
        ]);
        
        if($validator->fails()) {
            throw new ValidationException($validator);
        }

        $customer->update($validator->validated());

        return $customer;
        
    }

}
