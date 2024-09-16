<?php
namespace App\Repositories;

use App\Models\Schedule;
use App\Repositories\ScheduleRepositoryInterface;

class ScheduleRepository implements ScheduleRepositoryInterface {

    public function getList(){

        return Schedule::all();

    }

    public function create($data){
        return [];
    }

    public function find($id){
        return $id;
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