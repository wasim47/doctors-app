<?php
namespace App\Repositories;

use App\Models\Schedule;
use App\Models\Shift;
use App\Repositories\ScheduleRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ScheduleRepository implements ScheduleRepositoryInterface {

    public function getApiList(){    
        return Schedule::with('doctor:id,first_name,last_name')->whereNull('deleted_at')->get();
    }


    ////////////////// Admin ////////
    public function getList(){
        return Schedule::with('doctor:id,first_name,last_name')->whereNull('deleted_at')->paginate(50);
    }

    public function create($data){
        $schedule = Schedule::create([
            'doctor_id' => $data['doctor_id'] ?? null,
            'branch_id' => $data['branch_id'] ?? null,
            'days_of_weeks' => $data['days_of_weeks'] ?? null,            
            'status' => $data['status'] ?? 1,
            'created_by' => $data['created_by'] ?? 1,
            'updated_by' => $data['updated_by'] ?? null,
        ]);

        foreach($data['shift'] as $k => $shift){
            if($shift){
                $shiftData = [
                    'schedule_id' => $schedule->id,
                    'shift' => $data['shift'][$k] ?? null,
                    'start_time' => $data['start_time'][$k] ?? null,
                    'end_time' => $data['end_time'][$k] ?? null,
                    'minutes_per_appointment' => $data['minutes_per_appointment'][$k] ?? 0,
                    'maximum_patients' => $data['maximum_patients'][$k] ?? 0,
                ];
                Shift::create($shiftData);
            }
        }

        return $schedule;
    }

    public function find($id){
        return Schedule::find($id);
    }


    public function update($id, array $data)
    {       
        $hospital = Schedule::find($id);
        $menuUpdate = array(
			'doctor_id' => $data['doctor_id'] ?? null,
			'days_of_weeks' => $data['days_of_weeks'] ?? null,
            'shift' => $data['shift'] ?? null,
            'start_time' => $data['start_time'] ?? null,
            'end_time' => $data['end_time'] ?? null,
            'minutes_per_appointment' => $data['minutes_per_appointment'] ?? 0,
            'maximum_patients' => $data['maximum_patients'] ?? 0,
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'status' => $data['status'] ?? 1,
            'updated_by' => $data['updated_by'] ?? null,
			'updated_at'=> date('Y-m-d H:i:s')
		 );

        return $hospital->update($menuUpdate);
    }


}