<?php

namespace App\Actions\DoctorSchedules;

use Carbon\Carbon;
use App\Models\Doctor;
use Carbon\CarbonInterval;
use App\Models\DoctorSchedule;
use App\Services\DoctorSchedule\AppointmentGenerator;
use App\Services\ValidationService\DoctorScheduleCreateValidator;

class DoctorScheduleAction
{
    protected $validator;

    public function __construct(DoctorScheduleCreateValidator $validator)
    {
        $this->validator = $validator;
    }

    public function execute($request)
    {
        $validatedData = $this->validator->validate($request);

        $doctor = Doctor::findOrFail($validatedData['doctor_id']);
        $date = Carbon::parse($validatedData['date']);
        $start_time = Carbon::parse($validatedData['start_time']);
        $end_time = Carbon::parse($validatedData['end_time']);


        (new AppointmentGenerator())->execute($doctor, $date, $start_time, $end_time);

        return 'Appointments have been successfully generated';


    }


}
