<?php
namespace App\Repositories;

use App\Models\Doctor;
use App\Repositories\DoctorRepositoryInterface;

class DoctorRepository implements DoctorRepositoryInterface {

    public function getList(){

        return Doctor::all();

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