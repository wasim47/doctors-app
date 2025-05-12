<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Services\HospitalService;
use App\Services\CommonService;
use Exception;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class HospitalController extends BaseController
{
    public function __construct(
        protected HospitalService $service,
    ) {}

    public function index()
    {
        $listData = $this->service->index();
        return view('admin.hospital.index', compact('listData'));
    }

    public function create()
    {
        return view('admin.hospital.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone_no' => 'required',
            'email' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric'
        ], [
            'name.required' => 'The hospital name is required.',
            'name.max' => 'The hospital name must not exceed 255 characters.',
            'phone_no.required' => 'Hospital is required.',
            'email.required' => 'Hospital is required.',
            'latitude.numeric' => 'The latitude must be a valid number.',
            'longitude.numeric' => 'The longitude must be a valid number.',
        ]);
        
        if ($request->hasFile('banner')) {
            if($request->file('banner')->isValid()) {
                try {
                    $file = $request->file('banner');
                    $savedFileName = 'hospital_'.time() . '.' . $file->getClientOriginalExtension();    

					$directoryPath = public_path('uploads/hospital');
                    
                    if (!file_exists(($directoryPath))) {
                        mkdir($directoryPath, 0755, true);
                    }
                    $pathLarge = $directoryPath.'/'.$savedFileName;
          			$this->imageResize($file,$pathLarge,$savedFileName, 1600, 660);

                } catch (Exception $e) {
                    dd($e);
              }
            }
        }
        else{
            $savedFileName = '';
         }

        $request['image'] = $savedFileName;
        $data = $request->except(['_token', '_method']);
        $data = array_merge($data, $validatedData);

        $this->service->store($data);
        return redirect()->route('hospital.index')->with('success', 'Hospital created successfully.');
    }

    public function show(int $id)
    {
        return response()->json($this->service->find($id));
    }
    
    public function edit(int $id)
    {
        $hospital = $this->service->find($id);
        return view('admin.hospital.edit', compact('hospital'));
    }

    public function update(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone_no' => 'required',
            'email' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ], [
            'name.required' => 'The hospital name is required.',
            'name.max' => 'The hospital name must not exceed 255 characters.',
            'phone_no.required' => 'Hospital is required.',
            'email.required' => 'Hospital is required.',
            'latitude.numeric' => 'The latitude must be a valid number.',
            'longitude.numeric' => 'The longitude must be a valid number.',
        ]);
        
        if ($request->hasFile('banner')) {
            if($request->file('banner')->isValid()) {
                try {
                    $file = $request->file('banner');
                    $savedFileName = 'hospital_'.time() . '.' . $file->getClientOriginalExtension();

					$directoryPath = public_path('uploads/hospital');
                    
                    if (!file_exists(($directoryPath))) {
                        mkdir($directoryPath, 0755, true);
                    }
                    $pathLarge = $directoryPath.'/'.$savedFileName;
          			$this->imageResize($file,$pathLarge,$savedFileName, 1600, 660);

                } catch (Exception $e) {
                    dd($e);
              }
            }
        }
        else{
            $savedFileName = $request->stillthumb;
         }

        $request['image'] = $savedFileName;
        $data = $request->except(['_token', '_method']);
        $data = array_merge($data, $validatedData);

        $this->service->update($id, $data);
        return redirect()->route('hospital.index')->with('success', 'Hospital updated successfully.');
    }

    public function imageResize($file, $path, $filename, $width, $height)
	{
		$img = Image::make($file);
		$img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

        $img->resizeCanvas($width, $height, 'center', false, array(255, 255, 255, 0));
		$img->save($path);
	}
}
