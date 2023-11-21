<?php

namespace App\Services\ValidationService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AppointmentCreateValidator
{

    public function validate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date|after_or_equal:now',
            'fee' => 'required|integer',
            'doctor_id' => 'required|exists:doctors,id',
            'customer_id' => 'required|exists:customers,id',
            'time' => 'required|date_format:H:i'
        ]);

        if($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }


}
