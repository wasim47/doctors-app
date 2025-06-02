<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorBranch;
use App\Models\DoctorExperience;
use App\Models\DoctorSpeciality;
use App\Models\Shift;
use App\Repositories\DoctorRepositoryInterface;
use App\Services\UtilityService;
use DateInterval;
use DatePeriod;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DoctorRepository implements DoctorRepositoryInterface
{
    public function __construct(
        protected UtilityService  $utility
    ) {}
    public function getApiList($data)
    {
        $iconPath = asset('uploads/doctor');
        $defaultMalePhoto = asset('assets/img/doctor-male.png');
        $defaultFemalePhoto = asset('assets/img/doctor-female.png');

        return Doctor::with('specialities:id,name','schedule')
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
                    ) AS doctor_photo
                ")
            )
            ->whereNull('deleted_at')
            ->whereHas('schedule')
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

    public function findApp($id, $branchId = null)
    {
        $doctor = Doctor::with([
            'specialities:id,name',
            // 'branches:id,name',
            'schedule' => function ($query) use ($branchId) {
                $query->with('branch:id,name,address')
                      ->where('branch_id', $branchId)
                      ->select('id', 'doctor_id', 'days_of_weeks', 'branch_id');
            }
        ])
        ->select('id', 'first_name', 'last_name', 'designation', 'degree', 'regular_fee')
        ->whereNull('deleted_at')
        ->where('id', $id)
        ->first();

        if (!$doctor) {
            return response()->json(['error' => 'Doctor not found'], 404);
        }
        return $doctor;
    }


    public function doctorSchedule($doctorId, $scheduleId, $appointment_date = null)
    {
        $shiftData = Shift::select('id', 'shift', 'start_time', 'end_time', 'minutes_per_appointment', 'maximum_patients')
            ->whereNull('deleted_at')
            ->where('schedule_id', $scheduleId)
            ->get();

        if (!$shiftData) {
            return response()->json(['error' => 'Doctor not found'], 404);
        }

        foreach ($shiftData as $shift) {
            $start = Carbon::createFromFormat('H:i:s', $shift->start_time)->format('g:i A');
            $end = Carbon::createFromFormat('H:i:s', $shift->end_time)->format('g:i A');
            $shift->times =  $start . ' to ' . $end;
            unset($shift->start_time);
            unset($shift->end_time);
        }

        return $shiftData;
    }

    function generateTime($shift, $scheduleId, $doctor_id, $appointment_date)
    {
        $start_time = $shift->start_time;
        $end_time = $shift->end_time;
        $interval_minutes = $shift->minutes_per_appointment;
        $shiftId = $shift->id;

        // Convert start and end times to timestamps
        $start = strtotime($start_time);
        $end = strtotime($end_time);

        // Validate time format
        if ($start === false || $end === false) {
            return ["Invalid time format"];
        }

        $bookedAppointments = Appointment::where([
            ['doctor_id', $doctor_id],
            ['schedule_id', $scheduleId],
            ['shift_id', $shiftId],
            ['appointment_date', $appointment_date],
            ['appointment_status', $this->utility::$appointmentStatus['pending']],
        ])->pluck('appointment_time')->toArray();

        // Step 2: Build time slots without querying inside loop
        $time_slots = [];
        $i = 1;
        while ($start <= $end) {
            $time = date("H:i", $start);
            $isBooked = in_array($time, $bookedAppointments) ? 1 : 0;
            $time_slots[] = ['time' => $time, 'isBooked' => $isBooked, 'serial' => $i];
            $start += $interval_minutes * 60;
            $i++;
        }

        return $time_slots;
    }

    public function doctorProfile($id)
    {
        $iconPath = asset('uploads/doctor');
        $defaultMalePhoto = asset('assets/img/doctor-male.png');
        $defaultFemalePhoto = asset('assets/img/doctor-female.png');

        $doctor = Doctor::with('specialities:id,name', 'experience:id,doctor_id,hospital_name,designation,start_date,end_date', 'hospital:id,name')
            ->select(
                'id',
                'first_name',
                'last_name',
                'hospital_id',
                'designation',
                'degree',
                'experience AS totalExperience',
                'about',
                'bmdc',
                DB::raw("
                COALESCE(
                    CONCAT('$iconPath/', image), 
                    CASE 
                        WHEN gender = 'Male' THEN '$defaultMalePhoto' 
                        WHEN gender = 'Female' THEN '$defaultFemalePhoto' 
                        ELSE '$defaultMalePhoto' 
                    END
                ) AS doctor_photo
            ")
            )
            ->whereNull('deleted_at')
            ->where('id', $id)
            ->first();

        if (!$doctor) {
            return response()->json(['error' => 'Doctor not found'], 404);
        }

        return $doctor;
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

        if (!empty($data['exp_designation']) && count($data['exp_designation']) > 0) {
            $doctorExperience = [];
            foreach ($data['exp_designation'] as $index => $item) {
                $doctorExperience[] = [
                    'doctor_id' => $doctor->id,
                    'designation' => $data['exp_designation'][$index],
                    'hospital_name' => $data['exp_hospital_name'][$index],
                    'start_date' => $data['exp_start_date'][$index],
                    'end_date' => $data['exp_end_date'][$index],
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DoctorExperience::insert($doctorExperience);
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
