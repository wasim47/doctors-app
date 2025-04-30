<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Models\PatientFamily;
use App\Models\PatientDocument;
use App\Models\User;
use App\Repositories\PatientRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PatientRepository implements PatientRepositoryInterface
{

    public function getFamilyList()
    {
        $getPatientID = Patient::select('id')->where('user_id', $this->getUserId())->first();
        if (!$getPatientID) {
            return false;
        }

        return PatientFamily::where('patient_id', $getPatientID->id)->select('id', 'first_name', 'last_name', 'relation', 'country_code', 'phone_no', 'email', 'gender', 'date_of_birth')->get();
    }

    public function documentList()
    {
        $baseUrl = env('BACKEND_URL');
        $getPatientID = Patient::select('id')->where('user_id', $this->getUserId())->first();
        if (!$getPatientID) {
            return false;
        }

        $documents = PatientDocument::where('patient_id', $getPatientID->id)
            ->select('id', 'document_name', 'file_path')
            ->get();

        $documents = $documents->map(function ($doc) use ($baseUrl) {
            if (!empty($doc->file_path)) {
                $doc->file_path = rtrim($baseUrl, '/') . '/' . ltrim($doc->file_path, '/');
            }
            return $doc;
        });

        return $documents;
    }


    ////////////////// Admin ////////
    public function getList()
    {
        return Patient::orderBy('id', 'desc')->paginate(50);
    }

    public function create($data)
    {
        $user = User::create([
            'first_name' => $data['first_name'] ?? '',
            'last_name' => $data['last_name'] ?? '',
            'name' => $data['first_name'] . ' ' . $data['last_name'],
            'dob' => $data['date_of_birth'] ?? null,
            'email' => $data['email'] ?? '',
            'country_code' => $data['country_code'] ?? '',
            'mobile' => $data['phone_no'] ?? '',
            'gender' => $data['gender'] ?? null,
            'status' => 1,
            'password' => bcrypt('patient-1234'),
            'user_type' => 'Patient',
            'created_by' => $data['created_by'] ?? 1,
            'updated_by' => $data['updated_by'] ?? null,
        ]);

        return Patient::create([
            'first_name' => $data['first_name'] ?? '',
            'last_name' => $data['last_name'] ?? '',
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'email' => $data['email'] ?? '',
            'country_code' => $data['country_code'] ?? '',
            'phone_no' => $data['phone_no'] ?? '',
            'gender' => $data['gender'] ?? null,
            'status' => $data['status'] ?? 1,
            'user_id' => $user->id,
            'created_by' => $this->getUserId(),
            'updated_by' => $data['updated_by'] ?? null,
        ]);
    }

    public function createFamily($data)
    {
        return PatientFamily::create([
            'first_name' => $data['first_name'] ?? '',
            'last_name' => $data['last_name'] ?? '',
            'date_of_birth' => $data['dob'] ?? null,
            'email' => $data['email'] ?? '',
            'relation' => $data['relation'] ?? '',
            'country_code' => $data['country_code'] ?? '',
            'phone_no' => $data['mobile'] ?? '',
            'gender' => $data['gender'] ?? null,
            'status' => 1,
            'patient_id' => $this->getPatientId(),
            'created_by' => $this->getUserId(),
            'updated_by' => $data['updated_by'] ?? null,
        ]);
    }

    public function find($id)
    {
        return Patient::find($id);
    }

    public function updateFamily($id, array $data)
    {
        $patientFamily = PatientFamily::find($id);
        if (!$patientFamily) {
            return false;
        }

        $menuUpdate = [
            'first_name' => $data['first_name'] ?? '',
            'last_name' => $data['last_name'] ?? '',
            'date_of_birth' => $data['dob'] ?? null,
            'email' => $data['email'] ?? '',
            'relation' => $data['relation'] ?? '',
            'country_code' => $data['country_code'] ?? '',
            'phone_no' => $data['mobile'] ?? '',
            'gender' => $data['gender'] ?? null,
            'status' => 1, // Ensure this is needed
            'patient_id' => $this->getPatientId(),
            'created_by' => $this->getUserId(),
            'updated_by' => $data['updated_by'] ?? $this->getUserId(),
        ];

        if ($patientFamily->update($menuUpdate)) {
            return $patientFamily; // Return updated model
        }

        return false;
    }


    public function update($id, array $data)
    {
        $patientData = Patient::find($id);
        $menuUpdate = array(
            'first_name' => $data['first_name'] ?? '',
            'last_name' => $data['last_name'] ?? '',
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'email' => $data['email'] ?? '',
            'country_code' => $data['country_code'] ?? '',
            'phone_no' => $data['phone_no'] ?? '',
            'gender' => $data['gender'] ?? null,
            'status' => $data['status'] ?? 1,
            'updated_at' => date('Y-m-d H:i:s')
        );

        return $patientData->update($menuUpdate);
    }


    public function documentUpload($data)
    {
        return PatientDocument::create([
            'patient_family_id' => $data['patient_family_id'] ?? '',
            'document_name' => $data['document_name'] ?? '',
            'file_name' => $data['file_name'] ?? '',
            'file_path' => $data['file_path'] ?? null,
            'mime_type' => $data['mime_type'] ?? '',
            'size' => $data['size'] ?? 0,
            'status' => 1,
            'patient_id' => $this->getPatientId(),
            'created_by' => $this->getUserId(),
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function documentUpdate($id, $data)
    {
        $document = PatientDocument::find($id);

        if (!$document) {
            return false;
        }

        $document->patient_family_id = $data['patient_family_id'] ?? $document->patient_family_id;
        $document->document_name = $data['document_name'] ?? $document->document_name;
        $document->file_name = $data['file_name'] ?? $document->file_name;
        $document->file_path = $data['file_path'] ?? $document->file_path;
        $document->mime_type = $data['mime_type'] ?? $document->mime_type;
        $document->size = $data['size'] ?? $document->size;
        $document->updated_by = $this->getUserId();
        $document->save();

        return $document;
    }


    public function deleteFamily($id)
    {
        $patientData = PatientFamily::find($id);

        if (!$patientData) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        return $patientData->delete(); // Soft delete the record
    }

    public function restoreFamily($id)
    {
        $patientData = PatientFamily::onlyTrashed()->find($id);

        if (!$patientData) {
            return response()->json(['message' => 'No deleted record found'], 404);
        }

        $patientData->restore(); // Restore the record

        return response()->json(['message' => 'Family member restored successfully', 'data' => $patientData]);
    }

    public function forceDeleteFamily($id)
    {
        $patientData = PatientFamily::onlyTrashed()->find($id);

        if (!$patientData) {
            return response()->json(['message' => 'No deleted record found'], 404);
        }

        $patientData->forceDelete(); // Permanently delete the record

        return response()->json(['message' => 'Family member permanently deleted']);
    }

    private function getPatientId()
    {
        $auth = Auth::guard('api');
        $getPatientID = Patient::select('id')->where('user_id', $auth->user()->id)->first();
        if (!$getPatientID) {
            return false;
        } else {
            return $getPatientID->id;
        }
    }

    private function getUserId()
    {
        $auth = Auth::guard('api');
        return $auth->user()->id;
    }
}
