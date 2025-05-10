<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\HospitalStoreRequest;
use App\Http\Resources\HospitalResource;
use App\Models\Hospital;
use App\Services\HospitalService;
use Symfony\Component\HttpFoundation\Response;

class HospitalController extends BaseController
{

    protected $service;

    public function __construct(HospitalService $service)
    {
        $this->service = $service;
        
    }
    
    public function index(){
        return HospitalResource::collection($this->service->index());
    }

    public function show($id){
        $response = $this->service->find($id);
        if($response){
            return $this->successResponse($this->service->find($id), 'Hospital Details', Response::HTTP_OK);
        }
        else{
            return $this->errorResponse('Hospital Not Found.', ['error' => 'Hospital Not Found'], 401);
        }
    }

    public function store(HospitalStoreRequest $request){
        return new HospitalResource($this->service->store($request->all()));
    }
}
