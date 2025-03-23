<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\CancelationStoreRequest;
use App\Http\Resources\CancelationResource;
use App\Models\Cancelation;
use App\Services\CancelationService;

class CancelationController extends BaseController
{

    protected $service;

    public function __construct(CancelationService $service)
    {
        $this->service = $service;
        
    }

    /**
     * @OA\Get(
     *     path="/api/cancelation",
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */

    //// Get all Speciality form app
    public function index(){
        
        // return response()->json($this->service->index(), 200);
        return CancelationResource::collection($this->service->index());
    }


    // Add new specialty with custom validation rules
    public function store(CancelationStoreRequest $request){

        // return response()->json($this->service->store($request->all()), 201);
        return new CancelationResource($this->service->store($request->all()));
    }
}
