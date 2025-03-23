<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\AppointmentStoreRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Services\AppointmentService;
use Illuminate\Http\Request;

class AppointmentController extends BaseController
{

    protected $service;

    public function __construct(AppointmentService $service)
    {
        $this->service = $service;
    }
    //// Get all Speciality form app
    public function index($type)
    {
        return AppointmentResource::collection($this->service->index($type));
    }

    public function show($id = null)
    {

        return response()->json($this->service->find($id));
    }

    public function store(AppointmentStoreRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $appointment = $this->service->store($validatedData);
            if($appointment){
                return response()->json([
                    'success' => true,
                    'message' => 'Appointment created successfully',
                    'data' => $appointment
                ], 201);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 422);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Handle unexpected errors
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
