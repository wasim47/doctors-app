<?php

namespace App\Services;

use App\Repositories\SpecialtyRepositoryInterface;

class SpecialtyService {

    protected $repository;

    public function __construct(SpecialtyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    ////////////////// API ////////
    public function getList(){

        return $this->repository->getApiList();
    }

    ////////////////// Admin ////////
    public function index(){

        return $this->repository->getList();
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
}