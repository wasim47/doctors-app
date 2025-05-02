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

    public function documentList()
    {
        return $this->successResponse(PatientResource::collection($this->service->documentList()), 'Patient Document Member List', Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:patient_families|max:255',
            'mobile' => 'nullable|unique:patient_families,phone_no',
            'relation' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422);
        }

        return $this->successResponse($this->service->storeApp($request->all()), 'Patient Added Successfully', Response::HTTP_OK);
    }


    public function updateFamily($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:patient_families,email,' . $id,
            'mobile' => 'nullable|unique:patient_families,phone_no,' . $id,
            'relation' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422);
        }

        $updateResponse = $this->service->updateFamily($id, $request->all());
        if (!$updateResponse) {
            return response()->json([
                'message' => 'Patient family inform not updated, Please try again',
            ], 422);
        }
        return $this->successResponse($updateResponse, 'Patient Updated Successfully', Response::HTTP_OK);
    }


    public function documentUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'document_name'  => 'required|array',
            'document_name.*' => 'required|string|max:255',
            'document_for'   => 'nullable|array',
            'document_for.*' => 'nullable|numeric',
            'files'          => 'required|array',
            'files.*'        => 'file|mimetypes:application/pdf,image/jpeg,image/png,image/jpg|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422);
        }

        $files = $request->file('files');
        $documentNames = $request->input('document_name');
        $documentFors = $request->input('document_for', []);

        // Ensure each file has a corresponding document name and optionally document_for
        if (count($files) !== count($documentNames)) {
            return response()->json([
                'message' => 'Mismatch between files and document names.',
            ], 422);
        }

        if (!empty($documentFors) && count($documentFors) !== count($files)) {
            return response()->json([
                'message' => 'Mismatch between files and document_for values.',
            ], 422);
        }

        $results = [];
        foreach ($files as $index => $file) {
            try {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $mimeType = $file->getMimeType();
                $fileSize = $file->getSize();
                $fileName = time() . '_' . uniqid() . '.' . $extension;

                $destinationPath = public_path('uploads/patient');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $file->move($destinationPath, $fileName);

                $data = [
                    'patient_family_id' => $documentFors[$index] ?? 0,
                    'document_name'     => $documentNames[$index] ?? '',
                    'file_name'         => $fileName,
                    'file_path'         => 'uploads/patient/' . $fileName,
                    'mime_type'         => $mimeType,
                    'size'              => $fileSize,
                ];

                $results[] = $this->service->documentUpload($data);
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Failed to upload one or more documents.',
                    'error'   => $e->getMessage(),
                ], 500);
            }
        }

        return $this->successResponse($results, 'Patient Documents Added Successfully', Response::HTTP_OK);
    }

    public function documentUpdate($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'document_for' => 'nullable',
            'document_name' => 'required|string|max:255',
            'file' => 'required|file|mimetypes:application/pdf,image/jpeg,image/png,image/jpg',
        ]);



        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $mimeType = $file->getMimeType();
            $fileSize = $file->getSize();
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . pathinfo(md5($originalName), PATHINFO_FILENAME) . '.' . $extension;

            $destinationPath = public_path('uploads/patient');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $fileName);

            $data = [
                'patient_family_id' => $request->input('document_for'),
                'document_name' => $request->input('document_name'),
                'file_name' => $fileName,
                'file_path' => 'uploads/patient/' . $fileName,
                'mime_type' => $mimeType,
                'size' => $fileSize,
            ];

            $updateResponse = $this->service->documentUpdate($id, $data);

            if (!$updateResponse) {
                return response()->json([
                    'message' => 'Patient document not updated, please try again',
                ], 422);
            }

            return $this->successResponse($updateResponse, 'Patient Document Updated Successfully', Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update document.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /** Patient Family soft delete and hard delete if need */
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

    /** Patient Document soft delete and hard delete if need */
    public function deleteDocument($id)
    {

        $updateResponse = $this->service->deleteDocument($id);
        if ($updateResponse) {
            return response()->json([
                'message' => 'Successfully Deleted',
            ], 200);
        }
    }

    public function restoreDocument($id)
    {
        $updateResponse = $this->service->restoreDocument($id);
        if ($updateResponse) {
            return response()->json([
                'message' => 'Successfully Restored',
            ], 200);
        }
    }

    public function forceDeleteDocument($id)
    {
        $updateResponse = $this->service->forceDeleteDocument($id);
        if ($updateResponse) {
            return response()->json([
                'message' => 'Successfully Deleted Permanently',
            ], 200);
        }
    }
}
