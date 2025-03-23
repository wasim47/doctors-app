<?php

namespace App\Services;

use App\Repositories\AppointmentRepositoryInterface;

class AppointmentService {

    protected $repository;

    public function __construct(AppointmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index($type){

        return $this->repository->getList($type);
    }


    public function store($data){

        return $this->repository->create($data);
    }

    public function find($id){

        return $this->repository->find($id);
    }

    public function update($id, $data){

        $this->repository->update($id, $data);
    }

    public function delete($id){

        $this->repository->delete($id);
    }
}