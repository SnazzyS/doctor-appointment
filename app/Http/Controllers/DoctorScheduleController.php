<?php

namespace App\Http\Controllers;

use App\Actions\DoctorSchedules\DoctorScheduleAction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DoctorScheduleController extends Controller
{
    public function store(DoctorScheduleAction $action, Request $request)
    {
        $action->execute($request);
        
        return response()->json([
            "Message" => "Doctor schedule created successfully"
        ], Response::HTTP_CREATED);
    }
}
