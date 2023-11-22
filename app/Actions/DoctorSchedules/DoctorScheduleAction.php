<?php

namespace App\Actions\DoctorSchedules;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Services\DoctorSchedule\AppointmentGenerator;
use App\Services\ValidationService\DoctorScheduleCreateValidator;
use Symfony\Component\HttpFoundation\Response;

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

        $appointmentGenerator = new AppointmentGenerator();
        $appointmentGenerator->execute($doctor, $date, $start_time, $end_time);

        return Response::HTTP_OK;


    }


}
