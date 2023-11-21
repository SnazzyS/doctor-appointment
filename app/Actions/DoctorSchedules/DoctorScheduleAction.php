<?php

namespace App\Actions\DoctorSchedules;

use Carbon\Carbon;
use App\Models\Doctor;
use Carbon\CarbonInterval;
use App\Models\DoctorSchedule;
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

        $slots = CarbonInterval::minutes(15)->toPeriod($start_time, $end_time);

        
        foreach ($slots as $slot) {
            $endslot = $slot->copy()->addMinutes(15);
            if ($endslot > $end_time) {
                break;
            }

            $doctorSchedule = new DoctorSchedule();
            $doctorSchedule->date = $date->format('Y-m-d');
            $doctorSchedule->start_time = $slot->format('H:i:s');
            $doctorSchedule->end_time = $endslot->format('H:i:s');
            $doctorSchedule->doctor_id = $doctor->id;
            $doctorSchedule->available = true;
            $doctorSchedule->save();
        }
    }


}
