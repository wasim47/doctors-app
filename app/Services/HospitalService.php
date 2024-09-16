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

        $this->repository->create($data);
    }

    public function find($data){

        $this->repository->create($data);
    }

    public function update($id, $data){

        $this->repository->update($id, $data);
    }

    public function delete($id){

        $this->repository->delete($id);
    }
}