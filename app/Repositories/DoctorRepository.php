<?php

namespace App\Repositories;

use App\Models\Doctor;
use App\Models\DoctorBranch;
use App\Models\DoctorSpeciality;
use App\Repositories\DoctorRepositoryInterface;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\DB;

class DoctorRepository implements DoctorRepositoryInterface
{

    public function getApiList($data)
    {
        $iconPath = asset('uploads/doctor');
        $defaultMalePhoto = asset('assets/img/doctor-male.png');
        $defaultFemalePhoto = asset('assets/img/doctor-female.png');

        return Doctor::with('specialities:id,name')
            ->select(
                'id',
                'first_name',
                'last_name',
                'bmdc',
                'degree',
                'designation',
                'gender',
                DB::raw("
                COALESCE(
                    CONCAT('$iconPath/', image), 
                    CASE 
                        WHEN gender = 'Male' THEN '$defaultMalePhoto' 
                        WHEN gender = 'Female' THEN '$defaultFemalePhoto' 
                        ELSE '$defaultMalePhoto' 
                    END
                ) AS icon
            ")
            )
            ->whereNull('deleted_at')
            ->when(!empty($data['speciality_id']), function ($query) use ($data) {
                $query->whereHas('specialities', function ($q) use ($data) {
                    $q->where('speciality_id', $data['speciality_id']);
                });
            })
            ->when(!empty($data['branch_id']), function ($query) use ($data) {
                $query->whereHas('branches', function ($q) use ($data) {
                    $q->where('branch_id', $data['branch_id']);
                });
            })
            ->when(!empty($data['keyword']), function ($query) use ($data) {
                $keyword = "%{$data['keyword']}%"; // Add wildcard for LIKE search
                $query->where(function ($q) use ($keyword) {
                    $q->where('first_name', 'like', $keyword)
                        ->orWhere('last_name', 'like', $keyword)
                        ->orWhere('bmdc', 'like', $keyword)
                        ->orWhere('degree', 'like', $keyword);
                });
            })
            ->get();
    }

    public function findApp($id)
    {
        $doctor = Doctor::with('specialities:id,name', 'branches:id,name', 'schedule:id,doctor_id,days_of_weeks', 'schedule.shift:id,schedule_id,shift,start_time,end_time,minutes_per_appointment,maximum_patients')
            ->select('id', 'first_name', 'last_name', 'designation', 'degree', 'regular_fee')
            ->whereNull('deleted_at')
            ->where('id', $id)
            ->first();

        if (!$doctor) {
            return response()->json(['error' => 'Doctor not found'], 404);
        }


        foreach ($doctor->schedule as $schedule) {
            foreach ($schedule->shift as $shed) {
                foreach ($schedule->shift as $shift) {
                    $time_slots = $this->generateTime($shift->start_time, $shift->end_time, $shift->minutes_per_appointment);
                    $shift->times =  $time_slots;
                }
            }
        }

        return $doctor;
    }

    function generateTime($start_time, $end_time, $interval_minutes)
    {
        $time_slots = [];

        // Convert start and end times to timestamps
        $start = strtotime($start_time);
        $end = strtotime($end_time);

        // Validate time format
        if ($start === false || $end === false) {
            return ["Invalid time format"];
        }

        // Generate time slots
        while ($start <= $end) {
            $time_slots[] = date("H:i", $start); // Format as HH:MM
            $start += $interval_minutes * 60; // Add interval in seconds
        }

        return $time_slots;
    }





    ////////////////// Admin ////////
    public function getList()
    {
        return Doctor::orderBy('id', 'desc')->paginate(50);
    }

    public function create($data)
    {
        $doctor = Doctor::create([
            'hospital_id' => $data['hospital_id'] ?? null,
            'first_name' => $data['first_name'] ?? '',
            'last_name' => $data['last_name'] ?? '',
            'bmdc' => $data['bmdc'] ?? null,
            'designation' => $data['designation'] ?? null,
            'degree' => $data['degree'] ?? null,
            'about' => $data['about'] ?? null,
            'experience' => $data['experience'] ?? null,
            'dob' => $data['dob'] ?? null,
            'email' => $data['email'] ?? '',
            'phone_no' => $data['phone_no'] ?? '',
            'regular_fee' => $data['regular_fee'] ?? 0.0,
            'report_fee' => $data['report_fee'] ?? 0.0,
            'report_fee_applicable' => $data['report_fee_applicable'] ?? null,
            'gender' => $data['gender'] ?? null,
            'start_date' => $data['start_date'] ?? date('Y-m-d'),
            'end_date' => $data['end_date'] ?? null,
            'image' => $data['image'] ?? null,
            'status' => $data['status'] ?? 1,
            'created_by' => $data['created_by'] ?? 1,
            'updated_by' => $data['updated_by'] ?? null,
        ]);

        if (!empty($data['speciality_id']) && count($data['speciality_id']) > 0) {
            $doctorSpecialities = [];
            foreach ($data['speciality_id'] as $specialityId) {
                $doctorSpecialities[] = [
                    'doctor_id' => $doctor->id,
                    'speciality_id' => $specialityId,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DoctorSpeciality::insert($doctorSpecialities);
        }

        if (!empty($data['branch_id']) && count($data['branch_id']) > 0) {
            $doctorBranches = [];
            foreach ($data['branch_id'] as $branchId) {
                $doctorBranches[] = [
                    'doctor_id' => $doctor->id,
                    'branch_id' => $branchId,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DoctorBranch::insert($doctorBranches);
        }



        return true;
    }

    public function find($id)
    {
        return Doctor::with('specialities', 'schedule', 'schedule.shift')->find($id);
    }


    public function update($id, array $data)
    {
        $hospital = Doctor::find($id);
        $menuUpdate = array(
            'hospital_id' => $data['hospital_id'] ?? null,
            'branch_id' => $data['branch_id'] ?? null,
            'first_name' => $data['first_name'] ?? '',
            'last_name' => $data['last_name'] ?? '',
            'bmdc' => $data['bmdc'] ?? null,
            'designation' => $data['designation'] ?? null,
            'degree' => $data['degree'] ?? null,
            'about' => $data['about'] ?? null,
            'experience' => $data['experience'] ?? null,
            'dob' => $data['dob'] ?? null,
            'email' => $data['email'] ?? '',
            'phone_no' => $data['phone_no'] ?? '',
            'regular_fee' => $data['regular_fee'] ?? 0.0,
            'report_fee' => $data['report_fee'] ?? 0.0,
            'report_fee_applicable' => $data['report_fee_applicable'] ?? null,
            'gender' => $data['gender'] ?? null,
            'image' => $data['image'] ?? null,
            'start_date' => $data['start_date'] ?? date('Y-m-d'),
            'end_date' => $data['end_date'] ?? null,
            'status' => $data['status'] ?? 1,
            'updated_at' => date('Y-m-d H:i:s')
        );

        $checkExist = DoctorSpeciality::where('doctor_id', $id);
        $doctorSpeciality = [
            'doctor_id' => $id,
            'speciality_id' => $data['speciality_id'],
            'status' => 1,
        ];
        if ($checkExist->first()) {
            $checkExist->update($doctorSpeciality);
        } else {
            DoctorSpeciality::create($doctorSpeciality);
        }

        return $hospital->update($menuUpdate);
    }
}
