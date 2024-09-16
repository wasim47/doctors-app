<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\DoctorStoreRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Services\DoctorService;
use OpenApi\Annotations as OA;

class DoctorController extends BaseController
{

    protected $service;

    public function __construct(DoctorService $service)
    {
        $this->service = $service;
        
    }
    
    /**
     * @OA\Get(
     *     path="/api/doctor",
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */

    //// Get all Speciality form app
    public function index(){
        
        // return response()->json($this->service->index(), 200);
        return DoctorResource::collection($this->service->index());
    }


    // Add new specialty with custom validation rules
    public function store(DoctorStoreRequest $request){

        // return response()->json($this->service->store($request->all()), 201);
        return new DoctorResource($this->service->store($request->all()));
    }
}
