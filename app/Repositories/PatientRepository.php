<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Models\PatientFamily;
use App\Models\PatientDocument;
use App\Models\PatientDocumentFile;
use App\Models\User;
use App\Repositories\PatientRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
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
        $getPatientID = Patient::select('id')->where('user_id', $this->getUserId())->first();
        if (!$getPatientID) {
            return false;
        }

        return PatientDocument::with([
            'patientFamily:id,first_name,last_name', 
            'files:id,file_path,document_id,created_at,updated_at'
        ])
        ->select('id', 'patient_family_id', 'document_name', 'created_at', 'updated_at')
        ->where('patient_id', $getPatientID->id)
        ->get()
        ->map(function ($doc) {
            $doc->created_at = $doc->created_at ? Carbon::parse($doc->created_at)->format('Y-m-d') : null;
            $doc->updated_at = $doc->updated_at ? Carbon::parse($doc->updated_at)->format('Y-m-d') : null;
            return $doc;
        });
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
        $inswerted =  PatientDocument::create([
            'patient_family_id' => $data['patient_family_id'] ?? 0,
            'document_name'     => $data['document_name'],
            'status'            => 1,
            'patient_id'        => $this->getPatientId(),
            'created_by'        => $this->getUserId(),
            'created_at'        => now(),
        ]);
        return $inswerted->id;
    }

    public function documentFileUpload($data, $action)
    {
        if ($action == 'insert') {
            $data['created_by'] = $this->getUserId();
            $data['created_at'] = now();
        } else {
            $data['updated_by'] = $this->getUserId();
            $data['updated_at'] = now();
        }

        return PatientDocumentFile::create($data);
    }



    public function documentUpdate($id, $data)
    {
        return PatientDocument::where('id', $id)->update($data);
    }

    public function deleteExistingFiles($documentId)
    {
        $files = PatientDocumentFile::where('document_id', $documentId)->get();

        foreach ($files as $file) {
            $filePath = public_path($file->file_path);
            if (file_exists($filePath)) {
                @unlink($filePath); // Use @ to suppress errors if file doesn't exist
            }
        }

        return PatientDocumentFile::where('document_id', $documentId)->delete();
    }

    /** Patient Document soft delete and hard delete if need */
    public function deleteDocument($id)
    {
        $patientData = PatientDocument::find($id);

        if (!$patientData) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        // Optional: soft delete related file records
        PatientDocumentFile::where('document_id', $id)->delete();
        return $patientData->delete(); // Soft delete the record
    }


    public function restoreDocument($id)
    {
        $patientData = PatientDocument::onlyTrashed()->find($id);

        if (!$patientData) {
            return response()->json(['message' => 'No deleted record found'], 404);
        }

        $patientData->restore(); // Restore the document

        // Restore related files
        PatientDocumentFile::onlyTrashed()
            ->where('document_id', $id)
            ->restore();

        return response()->json(['message' => 'Document restored successfully', 'data' => $patientData]);
    }


    public function forceDeleteDocument($id)
    {
        $patientData = PatientDocument::onlyTrashed()->with('files')->find($id);

        if (!$patientData) {
            return ['status' => false, 'message' => 'No deleted record found', 'code' => 404];
        }

        foreach ($patientData->files as $file) {
            $filePath = public_path($file->file_path);
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        PatientDocumentFile::where('document_id', $id)->forceDelete();
        $patientData->forceDelete();

        return ['status' => true, 'message' => 'Successfully Deleted Permanently', 'code' => 200];
    }





    /** Patient Family soft delete and hard delete if need */
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
