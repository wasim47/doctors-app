<?php

namespace App\Services;

use App\Repositories\CommonRepositoryInterface;

class CommonService {

    protected $repository;

    public function __construct(CommonRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function branchList(){
        return $this->repository->getBranch();
    }

    public function hospitalList(){
        return $this->repository->getHospital();
    }

    public function specialityList(){
        return $this->repository->getSpeciality();
    }

    public function doctorList(){
        return $this->repository->getDoctors();
    }
}