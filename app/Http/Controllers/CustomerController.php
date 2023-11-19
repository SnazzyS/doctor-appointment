<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Actions\Customers\CustomerShowAction;
use Symfony\Component\HttpFoundation\Response;
use App\Actions\Customers\CustomerCreateAction;
use App\Actions\Customers\CustomerDeleteAction;
use App\Actions\Customers\CustomerUpdateAction;

class CustomerController extends Controller
{
    public function index(CustomerShowAction $action)
    {
        return response()->json($action->execute());
    }

    public function store(CustomerCreateAction $customerCreateAction, Request $request)
    {
        $customer = $customerCreateAction->execute($request->all());

        return response()->json([
            'customer' => $customer,
            'messeage' => 'Customer added successfully'
        ], Response::HTTP_CREATED);
    }

    public function update(CustomerUpdateAction $action, Request $request, $id)
    {

        $doctor = Customer::findOrFail($id);

        $action->execute($request->all(), $doctor);

        return response()->json([
            'doctor' => $doctor,
            'message' => 'Doctor updated successfully'
        ], Response::HTTP_ACCEPTED);
    }

    public function destroy(CustomerDeleteAction $action, $id)
    {
        $customer = $action->execute($id);

        return response()->json([
            'doctor' => $customer,
            'message' => 'Customer deleted successfully'
        ]);
    }
}
