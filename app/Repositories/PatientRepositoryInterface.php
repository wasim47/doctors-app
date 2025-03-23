<?php

namespace App\Repositories;

interface PatientRepositoryInterface
{
    public function getList();
    public function getFamilyList();
    public function createFamily(array $data);
    public function create(array $data);
    public function find($id);
    public function update($id, array $data);
    public function updateFamily($id, array $data);
    public function deleteFamily($id);
    public function restoreFamily($id);
    public function forceDeleteFamily($id);
}
