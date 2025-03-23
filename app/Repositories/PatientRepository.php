<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Models\PatientFamily;
use App\Models\User;
use App\Repositories\PatientRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PatientRepository implements PatientRepositoryInterface
{

    public function getFamilyList()
    {
        $auth = Auth::guard('api');
        return PatientFamily::where('patient_id', $auth->user()->id)->select('id', 'first_name', 'last_name', 'relation', 'phone_no', 'email', 'gender', 'date_of_birth')->get();
    }

    ////////////////// Admin ////////
    public function getList()
    {
        return Patient::orderBy('id', 'desc')->paginate(50);
    }

    public function create($data)
    {
        $auth = Auth::guard('api');
        $user = User::create([
            'first_name' => $data['first_name'] ?? '',
            'last_name' => $data['last_name'] ?? '',
            'name' => $data['first_name'] . ' ' . $data['last_name'],
            'dob' => $data['date_of_birth'] ?? null,
            'email' => $data['email'] ?? '',
            'mobile' => $data['phone_no'] ?? '',
            'gender' => $data['gender'] ?? null,
            'status' => 1,
            'password' => bcrypt('patient-1234'),
            'user_type' => 'Patient',
            'created_by' => $data['created_by'] ?? 1,
            'updated_by' => $data['updated_by'] ?? null,
        ]);

        $patient = Patient::create([
            'first_name' => $data['first_name'] ?? '',
            'last_name' => $data['last_name'] ?? '',
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'email' => $data['email'] ?? '',
            'phone_no' => $data['phone_no'] ?? '',
            'gender' => $data['gender'] ?? null,
            'status' => $data['status'] ?? 1,
            'user_id' => $user->id,
            'created_by' => $auth->user()->id,
            'updated_by' => $data['updated_by'] ?? null,
        ]);

        return $patient;
    }

    public function createFamily($data)
    {

        $auth = Auth::guard('api');
        $patient = PatientFamily::create([
            'first_name' => $data['first_name'] ?? '',
            'last_name' => $data['last_name'] ?? '',
            'date_of_birth' => $data['dob'] ?? null,
            'email' => $data['email'] ?? '',
            'relation' => $data['relation'] ?? '',
            'phone_no' => $data['mobile'] ?? '',
            'gender' => $data['gender'] ?? null,
            'status' => 1,
            'patient_id' => $auth->user()->id,
            'created_by' => $auth->user()->id,
            'updated_by' => $data['updated_by'] ?? null,
        ]);

        return $patient;
    }

    public function find($id)
    {
        return Patient::find($id);
    }

    public function updateFamily($id, array $data)
    {
        $patientFamily = PatientFamily::find($id);

        // Ensure the record exists before updating
        if (!$patientFamily) {
            return false;
        }

        $user = Auth::guard('api')->user();

        $menuUpdate = [
            'first_name' => $data['first_name'] ?? '',
            'last_name' => $data['last_name'] ?? '',
            'date_of_birth' => $data['dob'] ?? null,
            'email' => $data['email'] ?? '',
            'relation' => $data['relation'] ?? '',
            'phone_no' => $data['mobile'] ?? '',
            'gender' => $data['gender'] ?? null,
            'status' => 1, // Ensure this is needed
            'patient_id' => $user->id,
            'created_by' => $user->id,
            'updated_by' => $data['updated_by'] ?? $user->id, // Default updated_by to the current user
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
            'phone_no' => $data['phone_no'] ?? '',
            'gender' => $data['gender'] ?? null,
            'status' => $data['status'] ?? 1,
            'updated_at' => date('Y-m-d H:i:s')
        );

        return $patientData->update($menuUpdate);
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
}
