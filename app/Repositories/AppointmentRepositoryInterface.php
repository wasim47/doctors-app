<?php

namespace App\Repositories;

interface AppointmentRepositoryInterface
{
    public function getList($type);
    public function create(array $data);
    public function find($id);
    // public function update($id, array $data);
    public function delete($id);
}
