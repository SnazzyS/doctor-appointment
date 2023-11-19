<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:now',
            'fee' => 'required|integer',
            'doctor_id' => 'required|exists:doctors,id',
            'customer_id' => 'required|exists:customers,id',
            'time' => 'required|date_format:H:i'
            // 'time' => ['required', 'date_format:H:i', new TimeAfterNow],
        ]);

        $date = Carbon::parse($request->date);
        $fee = $request->fee;
        $doctor = $request->doctor_id;
        $customer = $request->customer_id;
        $start_time = Carbon::parse($request->time);
        $end_time = $start_time->copy()->subMinutes(15);

        // $doctorSchedule = DoctorSchedule::where('doctor_id', $doctor)->get();
        
        $doctorAvailibity = DoctorSchedule::where('doctor_id', $doctor)
        ->where('date', $date)
        ->where('start_time', $start_time)
        ->where('end_time', $end_time)
        ->where('available', true)
        ->get();

        $timeAvailibilty = DoctorSchedule::where('start_time', $start_time)->get();
     
        if(!$timeAvailibilty->contains('available', true)) {
            return response()->json([
                "Message" => "Appointment is not available at this time"
            ], Response::HTTP_BAD_REQUEST);
        }
    

        if (!$doctorAvailibity) {
            return response()->json([
                "Message" => "Appointment is not available at this time"
            ], Response::HTTP_BAD_REQUEST);
        }

        

        $appointment = new Appointment();

        $appointment->date = $date;
        $appointment->fee = $fee;
        $appointment->doctor_id = $doctor;
        $appointment->customer_id = $customer;
        $appointment->time = $start_time;
        $appointment->save();

        DoctorSchedule::where('start_time', $start_time)->update(['available' => false]);


    }
}
