<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleStoreRequest;
use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use App\Services\ScheduleService;

class ScheduleController extends Controller
{

    protected $service;

    public function __construct(ScheduleService $service)
    {
        $this->service = $service;
        
    }

    /**
     * @OA\Get(
     *     path="/api/schedule",
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    //// Get all Speciality form app
    public function index(){
        
        // return response()->json($this->service->index(), 200);
        return ScheduleResource::collection($this->service->index());
    }


    // Add new specialty with custom validation rules
    public function store(ScheduleStoreRequest $request){

        // return response()->json($this->service->store($request->all()), 201);
        return new ScheduleResource($this->service->store($request->all()));
    }
}
