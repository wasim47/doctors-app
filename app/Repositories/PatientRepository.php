<?php
namespace App\Repositories;

use App\Models\Patient;
use App\Repositories\PatientRepositoryInterface;

class PatientRepository implements PatientRepositoryInterface {

    public function getList(){

        return Patient::all();

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