<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Models\Patient;
use App\Repositories\AppointmentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentRepository implements AppointmentRepositoryInterface
{


    /********** For APP Api  */
    public function getList($type)
    {

        $auth = Auth::guard('api');
        $getPatientID = Patient::select('id')->where('user_id', $auth->user()->id)->first();

        if (!$getPatientID) {
            return false;
        }


        $query = Appointment::with('doctor:id,first_name,last_name,degree,designation', 'doctor.specialities:id,name')
            ->select('id', 'doctor_id', 'patient_id', 'appointment_date', 'appointment_time')
            ->where('patient_id', $getPatientID->id);

            
        if ($type != 'all') {
            if ($type == 'upcomming') {
                $now = now()->format('Y-m-d H:i:s');
                $query->whereRaw("STR_TO_DATE(CONCAT(appointment_date, ' ', appointment_time), '%Y-%m-%d %H:%i:%s') >= ?", [$now]);
            }
            else {
                $query->where('appointment_status', ucfirst($type));
            }
        }

        /* dd(
            $query->toSql(),
            $query->getBindings()
        ); */
        $appointment = $query->get();
        return $appointment;
    }

    public function create($data)
    {
        $auth = Auth::guard('api');
        $getPatientID = Patient::select('id')->where('user_id', $auth->user()->id)->first();

        if (!$getPatientID) {
            return false;
        }

        $getLastSerialOfDoctor = Appointment::where('doctor_id', $data['doctor_id'])->select('serial_no')->orderBy('id', 'DESC')->limit(1)->first();
        if ($getLastSerialOfDoctor) {
            $serialNo = $getLastSerialOfDoctor->serial_no + 1;
        } else {
            $serialNo = 1;
        }
        $appointmentSubmit = Appointment::create([
            'doctor_id' => $data['doctor_id'],
            'patient_id' => $getPatientID->id,
            'patient_family_id' => $data['patient_family_id'] ?? null,
            'schedule_id' => $data['schedule_id'],
            'shift_id' => $data['shift_id'],
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
            // 'appointment_time' => Carbon::now()->format('H:i:s'),
            'appointment_type' => "Online Appointment",
            'reason' => "Doctor visiting",
            'serial_no' => $serialNo,
            'appointment_status' => 'Pending',
            'payment_status' => "Unpaid",
            'created_by' => $auth->user()->id
        ]);

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
                ->find($appointmentSubmit->id);


            $appointment->serial_no = str_pad($appointment->serial_no, 2, '0', STR_PAD_LEFT);
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


    public function update($id, array $data)
    {
        return $data;
    }

    public function delete($id)
    {
        return $id;
    }
}
