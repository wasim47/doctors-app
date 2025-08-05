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

    public function rules(): array
    {
        return [
            'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
            'patient_family_id' => ['nullable', 'integer', 'exists:patient_families,id'], // Check correct table
            'schedule_id' => ['nullable', 'integer', 'exists:schedules,id'],
            'shift_id' => ['nullable', 'integer', 'exists:shifts,id'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['nullable'],
            'serial_no' => ['nullable'],
            'appointment_id' => ['nullable'],
        ];
    }

}