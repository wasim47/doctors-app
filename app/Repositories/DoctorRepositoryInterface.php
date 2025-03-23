<?php

namespace App\Repositories;

interface DoctorRepositoryInterface
{
    public function getApiList($data);   // For API use
    public function findApp($id);   // For API use
    public function getList();
    public function create(array $data);
    public function find($id);
    public function update($id, array $data);
}
