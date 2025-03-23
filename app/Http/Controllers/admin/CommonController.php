<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class CommonController extends Controller
{
	public function deletedata(Request $req)
	{
		$id = $req->id;
		$deletetype = $req->deletetype;
		$tablename = $req->tablename;

		if ($deletetype == 'single') {
			DB::table($tablename)->where('id', $id)->delete();
		} elseif ($deletetype == 'multiple') {
			DB::table($tablename)->whereIn('id', $id)->delete();
		}
		return $id;
	}

	public function permissions(Request $req)
	{
		$approve_val = $req->approve_val;
		$valuearray = explode(',', $approve_val);
		//dd($valuearray);
		$tablename = $req->tablename;
		$status = $req->status;

		$arrayuval =  array(
			'status' => $status
		);
		$updval = DB::table($tablename)->whereIn('id', $valuearray)->update($arrayuval);

		return Redirect::back();
	}

	public function updateSlug(Request $req)
	{
		//////////////// Update Slug /////////////////

		/*$allDatas = DB::table('hospitals')->whereNull('email')->get();
		$i=0;
		foreach($allDatas as $datas){
			$i++;
			$makeemail = 'bd-icu'.$i.'@bd-icu.com';
			//echo $makeemail;
			//$arrayvals = array('email'=>$makeemail);
			$arrayvals = array('email'=>$makeemail);
			DB::table('hospitals')->where('id', $datas->id)->update($arrayvals);
			DB::table('hospital_users')->where('hospital_id', $datas->id)->update($arrayvals);
		}*/

		/*$allDatas = DB::table('icutypes')->get();
		$i=0;
		foreach($allDatas as $datas){
			$i++;
			$icuvals = array('icutype_val'=>$datas->name);
			$bedyvals = array('bedtype_val'=>$datas->name);
			
			DB::table('icu_reports')->where('icutype', $datas->id)->update($icuvals);
			DB::table('bed_reports')->where('bedtype', $datas->id)->update($bedyvals);
		}*/

		$getDatas = DB::table('menus')->get();
		foreach ($getDatas as $gData) {
			// $expval = explode(' ', $gData->title);
			// $impval = implode('-', $expval);
			// $slug   = str_replace([',', "'", '"', '/', '|', '.', '`'], '', $impval);

			$menuUpdate = array(
				'uri' => Str::slug($gData->title),
				'updated_at' => date('Y-m-d H:i:s')
			);

			DB::table('menus')->where('id', $gData->id)->update($menuUpdate);
		}

		/*$allDatas = DB::table('divisions')->get();
		$i=0;
		foreach($allDatas as $datas){
			$i++;
			$icuvals = array('division_id'=>$datas->name);
			
			DB::table('icu_reports')->where('division_id', $datas->id)->update($icuvals);
			DB::table('bed_reports')->where('division_id', $datas->id)->update($icuvals);
		}*/
	}

	/*public function updateSlug()
	{
		$getDatas = DB::table('gift_card_groups')->get();		
		foreach($getDatas as $gData){
			$expval=explode(' ',$gData->name);
			$impval=implode('-',$expval);
			$slug   = str_replace([',', "'",'"', '/','|','.','`'],'' , $impval);
			
			 $menuUpdate = array(
				'slug'=> $slug
				'updated_at'=> date('Y-m-d H:i:s')
			 );
	
			DB::table('gift_card_groups')->where('id',$gData->id)->update($menuUpdate);		
		}
	}*/






	public function sampleFileDownload(Request $request)
	{
		$getFile = $request->filename . '.csv';
		$filePath = public_path("samplefiles/" . $getFile);
		$headers = ['Content-Type: application/csv'];
		return response()->download($filePath, $getFile, $headers);
	}
}
