<?php

namespace App\Services;

use App\Repositories\PatientRepositoryInterface;

class PatientService {

    protected $repository;

    public function __construct(PatientRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(){

        return $this->repository->getList();
    }

    public function patientList(){

        return $this->repository->getFamilyList();
    }


    public function storeApp($data){

        return $this->repository->createFamily($data);
    }

    public function store($data){

        return $this->repository->create($data);
    }

    public function find($id){

        return $this->repository->find($id);
    }

    public function update($id, $data){

        return $this->repository->update($id, $data);
    }

    public function updateFamily($id, $data){

        return $this->repository->updateFamily($id, $data);
    }

    public function deleteFamily($id){

        return $this->repository->deleteFamily($id);
    }

    public function restoreFamily($id){

        return $this->repository->restoreFamily($id);
    }

    public function forceDeleteFamily($id){

        return $this->repository->forceDeleteFamily($id);
    }
}