<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpecialtyStoreRequest;
use App\Http\Resources\SpecialtyResource;
use App\Models\Specialty;
use App\Services\SpecialtyService;

class SpecialtyController extends Controller
{

    protected $service;

    public function __construct(SpecialtyService $service)
    {
        $this->service = $service;
        
    }
    /**
     * @OA\Get(
     *     path="/api/speciality",
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */

    //// Get all Speciality form app
    public function index(){
        
        // return response()->json($this->service->index(), 200);
        return SpecialtyResource::collection($this->service->index());
    }


    // Add new specialty with custom validation rules
    public function store(SpecialtyStoreRequest $request){

        // return response()->json($this->service->store($request->all()), 201);
        return new SpecialtyResource($this->service->store($request->all()));
    }
}
