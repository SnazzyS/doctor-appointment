<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Doctor;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use App\Models\DoctorSchedule;
use Symfony\Component\HttpFoundation\Response;

class DoctorScheduleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|integer|exists:doctors,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $doctor = Doctor::findOrFail($request->doctor_id);
        $date = Carbon::parse($request->date);
        $start_time = Carbon::parse($request->start_time);
        $end_time = Carbon::parse($request->end_time);

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

        return response()->json([
            "Message" => "Doctor schedule created successfully"
        ], Response::HTTP_CREATED);
    }
}
