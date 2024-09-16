<?php
namespace App\Repositories;

use App\Models\Appointment;
use App\Repositories\AppointmentRepositoryInterface;

class AppointmentRepository implements AppointmentRepositoryInterface {

    public function getList(){

        return Appointment::all();

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