<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\AppointmentStoreRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Services\AppointmentService;
use App\Services\UtilityService;
use Illuminate\Http\Request;

class AppointmentController extends BaseController
{

    public function __construct(
        protected AppointmentService $service,
        protected UtilityService  $utility
    ) {}
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


    /* public function reschedule($id, AppointmentStoreRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $appointment = $this->service->reschedule($id, $validatedData);
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
    } */

    public function cancelAppointment($id)
    {
        try {
            $appointment = Appointment::where([['appointment_status','!=', $this->utility::$appointmentStatus['cancelled']],['id',$id]])->first();
            if($appointment){
                $update = $appointment->update(['appointment_status' => $this->utility::$appointmentStatus['cancelled']]);
                if($update){
                    return response()->json([
                        'success' => true,
                        'message' => 'Appointment '.$this->utility::$appointmentStatus['cancelled'].' successfully',
                    ], 201);
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Appointment Not Cancelled'
                ], 422);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Appointment Not Found'
            ], 422);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
