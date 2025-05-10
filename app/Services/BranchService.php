<?php

namespace App\Services;

use App\Repositories\BranchRepositoryInterface;

class BranchService {

    protected $repository;

    public function __construct(BranchRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getApiList($doctorId){

        return $this->repository->getApiList($doctorId);
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

    public function update($id, $data){

        return $this->repository->update($id, $data);
    }
}