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
    public function index(){
        
        return AppointmentResource::collection($this->service->index());
    }

    public function show($id = null){
        
        return response()->json($this->service->find($id));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_no' => 'required',
            'email' => 'required',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female,Other,Not Declare',
        ]);

        $data = $request->except(['_token', '_method']);
        $data = array_merge($data, $validatedData);

        $appointment = $this->service->store($data);
        return new AppointmentResource($appointment);
    }
}
