<?php

namespace App\Actions\Doctors;

use App\Models\Doctor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DoctorUpdateAction
{
    public function execute($data, $doctor)
    {
        $validator = Validator::make($data, [
            'name' => 'required'
        ]);

        if($validator->fails()) {
            throw new ValidationException($validator);
        }

        $doctor->update($validator->validated());

        return $doctor;


    }

}
