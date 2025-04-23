<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AppointmentStoreRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::guard('api')->check();
    }

    /* public function rules(): array
    {
        return [
            'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'schedule_id' => ['required', 'integer', 'exists:schedules,id'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required'],
            'appointment_type' => ['required', 'string', 'max:255'],
            'reason' => ['nullable', 'string'],
            'serial_no' => ['required', 'integer'],
            'appointment_status' => ['nullable', 'string', 'max:50'],
            'payment_status' => ['required', 'string', 'max:255'],
        ];
    } */

    public function rules(): array
    {
        return [
            'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
            'patient_family_id' => ['nullable', 'integer', 'exists:patient_families,id'], // Check correct table
            'schedule_id' => ['required', 'integer', 'exists:schedules,id'],
            'shift_id' => ['required', 'integer', 'exists:shifts,id'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required'],
            'appointment_id' => ['nullable'],
        ];
    }

}