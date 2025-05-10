<?php
namespace App\Repositories;

use App\Models\Branch;
use App\Models\DoctorBranch;
use App\Repositories\BranchRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BranchRepository implements BranchRepositoryInterface {

    public function getApiList($doctorId){
        $query = Branch::select('id','name','contact','hotline','address','latitude','longitude');

        if($doctorId){
            $doctorBranch = DoctorBranch::select('branch_id')->where('doctor_id', $doctorId)->pluck('branch_id')->toArray();
            $query->whereIn('id', $doctorBranch);
        }

        return $query->get();
    }

    ////////////////// Admin ////////
    public function getList(){
        return Branch::with('hospital')->orderBy('id','desc')->paginate(50);
    }

    public function create($data){
        return Branch::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'contact' => $data['contact'],
            'hotline' => $data['hotline'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'hospital_id' => $data['hospital_id'],
            'status' => $data['status'],
            'created_by' => 1
        ]);
    }

    public function find($id){
        return Branch::with('hospital')->find($id);
    }


    public function update($id, array $data)
    {
        $branch = Branch::find($id);
        $menuUpdate = array(
			'name'=>  $data['name'],
			'address' => $data['address'],
            'contact' => $data['contact'],
            'hotline' => $data['hotline'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'hospital_id' => $data['hospital_id'],
			'status'=>  $data['status'],
			'updated_at'=> date('Y-m-d H:i:s')
		 );

        return $branch->update($menuUpdate);
    }


}