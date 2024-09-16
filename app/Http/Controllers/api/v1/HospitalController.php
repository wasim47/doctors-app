<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\HospitalStoreRequest;
use App\Http\Resources\HospitalResource;
use App\Models\Hospital;
use App\Services\HospitalService;

class HospitalController extends Controller
{

    protected $service;

    public function __construct(HospitalService $service)
    {
        $this->service = $service;
        
    }
    /**
     * @OA\Get(
     *     path="/api/hospital",
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    //// Get all Speciality form app
    public function index(){
        
        // return response()->json($this->service->index(), 200);
        return HospitalResource::collection($this->service->index());
    }


    // Add new specialty with custom validation rules
    public function store(HospitalStoreRequest $request){

        // return response()->json($this->service->store($request->all()), 201);
        return new HospitalResource($this->service->store($request->all()));
    }
}
