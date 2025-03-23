<?php
namespace App\Repositories;

use App\Models\Hospital;
use App\Repositories\HospitalRepositoryInterface;
use Illuminate\Support\Facades\DB;

class HospitalRepository implements HospitalRepositoryInterface {

    public function getApiList(){
        return Hospital::select('id','name','address')->get();
    }

    ////////////////// Admin ////////
    public function getList(){
        return Hospital::orderBy('id','desc')->paginate(50);
    }

    public function create($data){
        return Hospital::create([
            'name' => $data['name'] ?? '',
            'address' => $data['address'] ?? '',
            'phone_no' => $data['phone_no'] ?? '',
            'email' => $data['email'] ?? '',
            'description' => $data['description'] ?? '',
            'latitude' => $data['latitude'] ?? 0,
            'longitude' => $data['longitude'] ?? 0,
            'status' => $data['status'],
            'created_by' => 1
        ]);
    }

    public function find($id){
        return Hospital::find($id);
    }


    public function update($id, array $data)
    {
        $hospital = Hospital::find($id);
        $menuUpdate = array(
			'name' => $data['name'] ?? '',
            'address' => $data['address'] ?? '',
            'phone_no' => $data['phone_no'] ?? '',
            'email' => $data['email'] ?? '',
            'description' => $data['description'] ?? '',
            'latitude' => $data['latitude'] ?? 0,
            'longitude' => $data['longitude'] ?? 0,
            'status' => $data['status'],
			'updated_at'=> date('Y-m-d H:i:s')
		 );

        return $hospital->update($menuUpdate);
    }


}