<?php
namespace App\Repositories;

use App\Models\Specialty;
use App\Repositories\SpecialtyRepositoryInterface;

class SpecialtyRepository implements SpecialtyRepositoryInterface {

    public function getList(){

        return Specialty::all();

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