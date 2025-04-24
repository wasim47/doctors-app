<?php

namespace App\Services;

use App\Repositories\DoctorRepositoryInterface;

class DoctorService {

    protected $repository;

    public function __construct(DoctorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

     ////////////////// API ////////
     public function getList($data){

        return $this->repository->getApiList($data);
    }


    public function findApp($id, $appointment_date = null){

        $data = $this->repository->findApp($id, $appointment_date);
        return $data;
    }

    public function doctorProfile($id){

        $data = $this->repository->doctorProfile($id);
        return $data;
    }


    ////////////////// Admin ////////
    public function index(){

        return $this->repository->getList();
    }


    public function store($data){

        return $this->repository->create($data);
    }

    public function find($id){

        $data = $this->repository->find($id);
        return $data;
    }

    public function update($id, $data){

        return $this->repository->update($id, $data);
    }
}