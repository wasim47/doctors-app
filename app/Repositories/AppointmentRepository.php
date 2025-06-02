<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Models\Patient;
use App\Repositories\AppointmentRepositoryInterface;
use App\Services\UtilityService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentRepository implements AppointmentRepositoryInterface
{

    public function __construct(
        protected UtilityService  $utility
    ) {}
    /********** For APP Api  */
    public function getList($type)
    {

        $auth = Auth::guard('api');
        $getPatientID = Patient::select('id')->where('user_id', $auth->user()->id)->first();
        if (!$getPatientID) {
            return false;
        }
        
        $query = Appointment::with('doctor:id,first_name,last_name,degree,designation,image','schedule:id,branch_id','schedule.branch:id,name,address')
            ->select('id AS appointment_id', 'doctor_id', 'patient_id', 'schedule_id','shift_id','serial_no','patient_family_id','appointment_date', 'appointment_time','appointment_status')
            ->where('patient_id', $getPatientID->id);

            
        if ($type != 'all') {
            if ($type == 'upcomming') {
                $now = now()->format('Y-m-d H:i:s');
                $query->where('appointment_status', UtilityService::$appointmentStatus['pending']);
                $query->whereRaw("STR_TO_DATE(CONCAT(appointment_date, ' ', appointment_time), '%Y-%m-%d %H:%i:%s') >= ?", [$now]);
            }
            else {
                $query->where('appointment_status', ucfirst($type));
            }
        }
        
        return $query->get();
    }

    public function create($data)
    {
        
        $auth = Auth::guard('api');
        $getPatientID = Patient::select('id')->where('user_id', $auth->user()->id)->first();

        if (!$getPatientID) {
            return false;
        }

        if(!empty($data['appointment_id'])){
            $existingAppintment = Appointment::where([['id',$data['appointment_id']],['patient_id', $getPatientID->id]])->first();
        }

        if((isset($data['schedule_id']) && $data['schedule_id']!='') && (isset($data['shift_id']) && $data['shift_id']!='')){
            $appointmentType = "Online Appointment";
        }
        else{
            $appointmentType = "Call for Appointment";
        }

        $appointmentData = [
            'doctor_id' => $data['doctor_id'],
            'patient_id' => $getPatientID->id,
            'patient_family_id' => $data['patient_family_id'] ?? null,
            'schedule_id' => $data['schedule_id'] ?? null,
            'shift_id' => $data['shift_id'] ?? null,
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
            'appointment_type' => $appointmentType,
            'reason' => "Doctor visiting",
            'serial_no' => $data['serial_no'],
            'appointment_status' => $this->utility::$appointmentStatus['pending'],
            'payment_status' => "Unpaid",
            'created_by' => $auth->user()->id
        ];

        if(!empty($existingAppintment)){
            $appointmentSubmit = $existingAppintment->update($appointmentData);
            $updatedId = $data['appointment_id'];
        }
        else{
            $appointmentSubmit = Appointment::create($appointmentData);
            $updatedId = $appointmentSubmit->id;
        }

        if ($appointmentSubmit) {
            $iconPath = asset('uploads/doctor');
            $defaultMalePhoto = asset('assets/img/doctor-male.png');
            $defaultFemalePhoto = asset('assets/img/doctor-female.png');

            $appointment = Appointment::with([
                'doctor' => function ($query) use ($iconPath, $defaultMalePhoto, $defaultFemalePhoto) {
                    $query->select(
                        'id',
                        'first_name',
                        'last_name',
                        'bmdc',
                        'degree',
                        'designation',
                        'gender',
                        'image',
                        DB::raw("
                COALESCE(
                    CONCAT('$iconPath/', image), 
                    CASE 
                        WHEN gender = 'Male' THEN '$defaultMalePhoto' 
                        WHEN gender = 'Female' THEN '$defaultFemalePhoto' 
                        ELSE '$defaultMalePhoto' 
                    END
                ) AS photo_url
            ")
                    );
                },
                'doctor.specialities:id,name'
            ])
                ->select(
                    'id',
                    'doctor_id',
                    'patient_id',
                    'serial_no',
                    'appointment_type',
                    'reason',
                    'appointment_status',
                    'appointment_date',
                    'appointment_time'
                )
                ->find($updatedId);


            //$appointment->serial_no = str_pad($appointment->serial_no, 2, '0', STR_PAD_LEFT);
            return $appointment;
        }

        return false;
    }

    public function find($id)
    {
        return Appointment::with('doctor:id,first_name,last_name', 'doctor.specialities:id,name')
            ->select('id', 'doctor_id', 'patient_id', 'appointment_type', 'reason', 'appointment_status', 'appointment_date', 'appointment_time')
            ->where('id', $id)
            ->first();
    }

    public function delete($id)
    {
        return $id;
    }
}
