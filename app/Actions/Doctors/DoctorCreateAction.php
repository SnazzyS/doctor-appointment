<?php

namespace App\Actions\Doctors;

use App\Models\Doctor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class DoctorCreateAction
{
    public function execute($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255'
        ]);

        if($validator->fails()) {
            throw new ValidationException($validator);
        }

        $doctor = Doctor::create($validator->validated());

        return $doctor;

    }
}
