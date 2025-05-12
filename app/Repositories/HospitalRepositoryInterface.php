<?php

namespace App\Repositories;

interface HospitalRepositoryInterface
{
    public function getApiList();   // For API use
    public function getList();
    public function create(array $data);
    public function find($id);
    public function profile($id);
    public function update($id, array $data);
}
