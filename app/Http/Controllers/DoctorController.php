<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Actions\Doctors\DoctorShowAction;
use App\Actions\Doctors\DoctorCreateAction;
use App\Actions\Doctors\DoctorDeleteAction;
use App\Actions\Doctors\DoctorUpdateAction;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DoctorController extends Controller
{
    public function index(DoctorShowAction $action)
    {
        return response()->json($action->execute());
    }

    public function store(DoctorCreateAction $action, Request $request)
    {
        $doctor = $action->execute($request->all());

        return response()->json([
            'doctor' => $doctor,
            'messeage' => 'Doctor added successfully'
        ], Response::HTTP_CREATED);
    }

    public function update(DoctorUpdateAction $action, Request $request, $id)
    {

        $doctor = Doctor::findOrFail($id);

        $action->execute($request->all(), $doctor);

        return response()->json([
            'doctor' => $doctor,
    'message' => 'Doctor updated successfully'
        ], Response::HTTP_ACCEPTED);
    }

    public function destroy(DoctorDeleteAction $action, $id)
    {
        try {
            $action->execute($id);
            return response()->json([
                'message' => 'Doctor deleted successfully'
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Doctor not found'
            ], Response::HTTP_NOT_FOUND);
        }
    }

}
