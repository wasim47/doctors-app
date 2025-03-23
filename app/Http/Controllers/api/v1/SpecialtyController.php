<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\SpecialtyStoreRequest;
use App\Http\Resources\SpecialtyResource;
use App\Models\Specialty;
use App\Services\SpecialtyService;
use Symfony\Component\HttpFoundation\Response;

class SpecialtyController extends BaseController
{

    protected $service;

    public function __construct(SpecialtyService $service)
    {
        $this->service = $service;
        
    }

    //// Get all Speciality form app
    public function index(){
        
        return $this->successResponse(SpecialtyResource::collection($this->service->getList()), 'Doctor Specialities', Response::HTTP_OK);
    }


    // Add new specialty with custom validation rules
    public function store(SpecialtyStoreRequest $request){

        //return new SpecialtyResource($this->service->store($request->all()));
    }
}
