<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\BranchStoreRequest;
use App\Http\Resources\BranchResource;
use App\Models\Branch;
use App\Services\BranchService;
use Symfony\Component\HttpFoundation\Response;

class BranchController extends BaseController
{

    protected $service;

    public function __construct(BranchService $service)
    {
        $this->service = $service;
        
    }

    public function index($doctorId = null){
        return $this->successResponse(BranchResource::collection($this->service->getApiList($doctorId)), 'Doctor Specialities', Response::HTTP_OK);
    }
}
