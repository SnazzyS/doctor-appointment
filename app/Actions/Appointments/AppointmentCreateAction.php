<?php

namespace App\Actions\Appointments;

use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ValidationService\AppointmentCreateValidator;

class AppointmentCreateAction
{
    protected $validator;

    public function __construct(AppointmentCreateValidator $validator)
    {
        $this->validator = $validator;
    }

    public function execute($request)
    {
        $validatedData = $this->validator->validate($request);
        
        $date = Carbon::parse($validatedData['date']->date);
        $fee = $validatedData['fee'];
        $doctor = $validatedData['doctor_id'];
        $customer = $validatedData['customer_id'];
        $start_time = $validatedData['time'];
        $end_time = $start_time->copy()->subMinutes(15);

        
        $this->checkDoctorAvailibilty($doctor, $date, $start_time, $end_time);

        // $doctorAvailibity = DoctorSchedule::where('doctor_id', $doctor)
        // ->where('date', $date)
        // ->where('start_time', $start_time)
        // ->where('end_time', $end_time)
        // ->where('available', true)
        // ->get();

        // $timeAvailibilty = DoctorSchedule::where('start_time', $start_time)->get();
     
        // if(!$timeAvailibilty->contains('available', true)) {
        //     return response()->json([
        //         "Message" => "Appointment is not available at this time"
        //     ], Response::HTTP_BAD_REQUEST);
        // }
    

        // if (!$doctorAvailibity) {
        //     return response()->json([
        //         "Message" => "Appointment is not available at this time"
        //     ], Response::HTTP_BAD_REQUEST);
        // }

        

        $appointment = new Appointment();

        $appointment->date = $date;
        $appointment->fee = $fee;
        $appointment->doctor_id = $doctor;
        $appointment->customer_id = $customer;
        $appointment->time = $start_time;
        $appointment->save();

        DoctorSchedule::where('start_time', $start_time)->update(['available' => false]);
    }

    private function checkDoctorAvailibilty($doctor, $date, $start_time, $end_time)
    {
        $doctorAvailibity = DoctorSchedule::where('doctor_id', $doctor)
        ->where('date', $date)
        ->where('start_time', $start_time)
        ->where('end_time', $end_time)
        ->where('available', true)
        ->get();

        if (!$doctorAvailibity) {
            return response()->json([
                "Message" => "Appointment is not available at this time"
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
