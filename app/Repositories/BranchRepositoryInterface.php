<?php

namespace App\Repositories;

interface BranchRepositoryInterface
{
    public function getApiList();   // For API use
    public function getList();
    public function create(array $data);
    public function find($id);
    public function update($id, array $data);
}
