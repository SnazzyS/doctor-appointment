<?php

namespace App\Services\DoctorSchedule;

use Carbon\CarbonInterval;
use App\Models\DoctorSchedule;
use App\Exceptions\ScheduleConflictException;

class AppointmentGenerator
{
    public const APPOINTMENT_TIME_IN_MINUTES = 15;

    public function execute($doctor, $date, $start_time, $end_time)
    {
        $slots = $this->generateTimeSlots($start_time, $end_time);

        foreach ($slots as $slot) {
            $endslot = $slot->copy()->addMinutes(15);
            if ($endslot > $end_time) {
                break;
            }
            
            $this->checkScheduleConflict($doctor, $date, $slot, $endslot);
            $this->createDoctorSchedule($doctor, $date, $slot, $endslot);
           
        }

    }

    private function generateTimeSlots($start_time, $end_time)
    {
        return CarbonInterval::minutes(self::APPOINTMENT_TIME_IN_MINUTES)->toPeriod($start_time, $end_time);
    }

    private function checkScheduleConflict($doctor, $date, $slot, $endslot)
    {
        $existingSchedule = DoctorSchedule::where('doctor_id', $doctor->id)
        ->where('date', $date->format('Y-m-d'))
        ->where('start_time', $slot->format('H:i:s'))
        ->where('end_time', $endslot->format('H:i:s'))
        ->first();

        if ($existingSchedule) {
            throw new ScheduleConflictException('A schedule for the specified time already exists.');
        }
    }

    private function createDoctorSchedule($doctor, $date, $slot, $endslot)
    {
        $doctorSchedule = new DoctorSchedule();
        $doctorSchedule->date = $date->format('Y-m-d');
        $doctorSchedule->start_time = $slot->format('H:i:s');
        $doctorSchedule->end_time = $endslot->format('H:i:s');
        $doctorSchedule->doctor_id = $doctor->id;
        $doctorSchedule->available = true;
        $doctorSchedule->save();
    }

}
