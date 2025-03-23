<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\PatientStoreRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Services\PatientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PatientController extends BaseController
{

    protected $service;

    public function __construct(PatientService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->successResponse(PatientResource::collection($this->service->patientList()), 'Patient Family Member List', Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:patient_families|max:255',
            'mobile' => 'required|unique:patient_families,phone_no',
            'relation' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422);
        }

        //return $this->service->storeApp($request->all());
        return $this->successResponse($this->service->storeApp($request->all()), 'Patient Added Successfully', Response::HTTP_OK);
    }


    public function updateFamily($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:patient_families,email,' . $id,
            'mobile' => 'required|unique:patient_families,phone_no,' . $id,
            'relation' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422);
        }

        $updateResponse = $this->service->updateFamily($id, $request->all());
        if(!$updateResponse){
            return response()->json([
                'message' => 'Patient family inform not updated, Please try again',
            ], 422);
        }
        return $this->successResponse($updateResponse, 'Patient Updated Successfully', Response::HTTP_OK);
    }


    public function deleteFamily($id)
    {

        $updateResponse = $this->service->deleteFamily($id);
        if ($updateResponse) {
            return response()->json([
                'message' => 'Successfully Deleted',
            ], 200);
        }
    }

    public function restoreFamily($id)
    {
        $updateResponse = $this->service->restoreFamily($id);
        if ($updateResponse) {
            return response()->json([
                'message' => 'Successfully Restored',
            ], 200);
        }
    }

    public function forceDeleteFamily($id)
    {
        $updateResponse = $this->service->forceDeleteFamily($id);
        if ($updateResponse) {
            return response()->json([
                'message' => 'Successfully Deleted Permanently',
            ], 200);
        }
    }
}
