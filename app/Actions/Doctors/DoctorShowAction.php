<?php

namespace App\Actions\Doctors;

use App\Models\Doctor;

class DoctorShowAction
{

    public function execute()
    {
        $doctors = Doctor::pluck('name', 'id');

        return $doctors;
    }
}
