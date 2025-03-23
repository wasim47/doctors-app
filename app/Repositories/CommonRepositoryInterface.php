<?php

namespace App\Repositories;

interface CommonRepositoryInterface
{
    public function getBranch();
    public function getHospital();
    public function getSpeciality();
    public function getDoctors();
}
