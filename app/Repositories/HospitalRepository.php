<?php
namespace App\Repositories;

use App\Models\Hospital;
use App\Repositories\HospitalRepositoryInterface;

class HospitalRepository implements HospitalRepositoryInterface {

    public function getList(){

        return Hospital::all();

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