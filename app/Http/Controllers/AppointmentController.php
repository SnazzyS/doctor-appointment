<?php

namespace App\Http\Controllers;


use App\Actions\Appointments\AppointmentCreateAction;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AppointmentController extends Controller
{
    public function store(AppointmentCreateAction $action, Request $request)
    {
        $action->execute($request);

        return response()->json([
         'message' => 'Appointment created successfully'
        ], Response::HTTP_CREATED);
    }
}
