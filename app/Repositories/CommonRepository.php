<?php
namespace App\Repositories;

use App\Models\Branch;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Specialty;
use App\Repositories\CommonRepositoryInterface;

class CommonRepository implements CommonRepositoryInterface {

    public function getBranch(){
        return Branch::select('id','name')->get();
    }

    public function getHospital(){
        return Hospital::select('id','name')->get();
    }

    public function getSpeciality(){
        return Specialty::select('id','name')->get();
    }

    public function getDoctors(){
        return Doctor::select('id','first_name','last_name')->get();
    }
}