<?php

namespace App\Services;

use App\Repositories\HospitalRepositoryInterface;

class HospitalService {

    protected $repository;

    public function __construct(HospitalRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(){

        return $this->repository->getList();
    }


    public function store($data){

        return $this->repository->create($data);
    }

    public function find($id){

        return $this->repository->find($id);
    }

    public function profile($id){

        return $this->repository->profile($id);
    }

    public function update($id, $data){

        return $this->repository->update($id, $data);
    }
}