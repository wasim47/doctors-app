<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentStoreRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Services\AppointmentService;

class AppointmentController extends Controller
{

    protected $service;

    public function __construct(AppointmentService $service)
    {
        $this->service = $service;
        
    }

    /**
     * @OA\Get(
     *     path="/api/appointment",
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */

    //// Get all Speciality form app
    public function index(){
        
        // return response()->json($this->service->index(), 200);
        return AppointmentResource::collection($this->service->index());
    }


    // Add new specialty with custom validation rules
    public function store(AppointmentStoreRequest $request){

        // return response()->json($this->service->store($request->all()), 201);
        return new AppointmentResource($this->service->store($request->all()));
    }
}
