<?php

namespace App\Actions\Doctors;

use App\Models\Doctor;

class DoctorDeleteAction
{
    public function execute($id)
    {
        $doctor = Doctor::findOrFail($id);

        $doctor->delete();

        return $doctor;
    }
}
