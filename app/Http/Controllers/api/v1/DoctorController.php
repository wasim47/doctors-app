<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\DoctorStoreRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Services\DoctorService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DoctorController extends BaseController
{

    protected $service;

    public function __construct(DoctorService $service)
    {
        $this->service = $service;
    }
    
    //// Get all Speciality form app
    public function index(Request $request){
        return $this->successResponse(DoctorResource::collection($this->service->getList($request->all())), 'All Doctor List', Response::HTTP_OK);
    }

    public function show($id = null, $appointment_date = null){
        return $this->successResponse($this->service->findApp($id,$appointment_date), 'Doctor Details', Response::HTTP_OK);
    }

    public function doctorSchedule($doctorId, $scheduleId, $appointment_date){
        return $this->service->doctorSchedule($doctorId, $scheduleId, $appointment_date);
        return $this->successResponse($this->service->doctorSchedule($doctorId, $scheduleId, $appointment_date), 'Doctor Details', Response::HTTP_OK);
    }

    public function profile($id = null){
        
        return $this->successResponse($this->service->doctorProfile($id), 'Doctor Profile', Response::HTTP_OK);
    }


    // Add new specialty with custom validation rules
    public function store(DoctorStoreRequest $request){

        return new DoctorResource($this->service->store($request->all()));
    }
}
