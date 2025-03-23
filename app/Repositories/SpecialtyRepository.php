<?php
namespace App\Repositories;

use App\Models\Specialty;
use App\Repositories\SpecialtyRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SpecialtyRepository implements SpecialtyRepositoryInterface{

    ////////////////// API ////////
    public function getApiList(){

        $defaultPhoto = asset('assets/img/statoscope.png');
        $iconPath = asset('uploads/speciality');

        return Specialty::select(
            'id',
            'name',
            'details',
            DB::raw("COALESCE(CONCAT('$iconPath/', icon), '$defaultPhoto') AS icon")
        )->get();
    }
    
    ////////////////// Admin ////////
    public function getList(){
        return Specialty::orderBy('id','desc')->paginate(50);
    }

    public function create($data){
        return Specialty::create([
            'name' => $data['name'],
            'details' => $data['details'],
            'icon' => $data['icon'],
            'status' => $data['status'],
            'created_by' => 1
        ]);
    }

    public function find($id){
        return Specialty::find($id);
    }


    public function update($id, array $data)
    {
        $speciality = Specialty::find($id);
        $menuUpdate = array(
			'name'=>  $data['name'],
			'details'=>  $data['details'],
			'icon'=>  $data['icon'],
			'status'=>  $data['status'],
			'updated_at'=> date('Y-m-d H:i:s')
		 );

        return $speciality->update($menuUpdate);
    }
}