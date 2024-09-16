<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientStoreRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Services\PatientService;

class PatientController extends Controller
{

    protected $service;

    public function __construct(PatientService $service)
    {
        $this->service = $service;
        
    }

    /**
     * @OA\Get(
     *     path="/api/patient",
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    //// Get all Speciality form app
    public function index(){
        
        // return response()->json($this->service->index(), 200);
        return PatientResource::collection($this->service->index());
    }


    // Add new specialty with custom validation rules
    public function store(PatientStoreRequest $request){

        // return response()->json($this->service->store($request->all()), 201);
        return new PatientResource($this->service->store($request->all()));
    }
}
