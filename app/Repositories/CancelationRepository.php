<?php
namespace App\Repositories;

use App\Models\Cancelation;
use App\Repositories\CancelationRepositoryInterface;

class CancelationRepository implements CancelationRepositoryInterface {

    public function getList(){

        return Cancelation::all();

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