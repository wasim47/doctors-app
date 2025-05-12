<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\SpecialtyStoreRequest;
use App\Http\Resources\SpecialtyResource;
use App\Models\Specialty;
use App\Services\SpecialtyService;
use Exception;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class SpecialtyController extends BaseController
{

    protected $service;

    public function __construct(SpecialtyService $service)
    {
        $this->service = $service;
        
    }
    /**
     * @OA\Get(
     *     path="/api/speciality",
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */

    //// Get all Speciality form app
    public function index(){
        
        $listData = $this->service->index();
        return view('admin/sepeciality/index', compact('listData'));
    }


    /* public function store(SpecialtyStoreRequest $request){
        return new SpecialtyResource($this->service->store($request->all()));
    } */


    public function create()
    {
        return view('admin.sepeciality.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'name' => 'required|string|unique:specialties|max:255'
        ]);

		if ($request->hasFile('image')) {
            if($request->file('image')->isValid()) {
                try {
                    $file = $request->file('image');
                    $savedFileName = 'speciality_'.time() . '.' . $file->getClientOriginalExtension();    

					$directoryPath = public_path('uploads/speciality');
                    
                    if (!file_exists(($directoryPath))) {
                        mkdir($directoryPath, 0755, true);
                    }
                    $pathLarge = $directoryPath.'/'.$savedFileName;
          			$this->imageResize($file,$pathLarge,$savedFileName, 100, 100);

                } catch (Exception $e) {
              }
            }
        }
        else{
            $savedFileName = '';
         }

        $request['icon'] = $savedFileName;
        $response = $this->service->store($request);
        return redirect('admin/sepeciality');
    }

    public function show($id)
    {
        $this->service->find($id);
    }

    public function edit($id)
    {
        $speciality = $this->service->find($id);
        return view('admin.sepeciality.edit',compact('speciality'));

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:specialties,name,' . $id,
        ]);

		if ($request->hasFile('image')) {
            if($request->file('image')->isValid()) {
                try {
                    $file = $request->file('image');
                    $savedFileName = 'speciality_'.time() . '.' . $file->getClientOriginalExtension();    

					$directoryPath = public_path('uploads/speciality');
                    
                    if (!file_exists(($directoryPath))) {
                        mkdir($directoryPath, 0777, true);
                    }
                    $pathLarge = $directoryPath.'/'.$savedFileName;
          			$this->imageResize($file,$pathLarge,$savedFileName, 100, 100);

                } catch (Exception $e) {
              }
            }
        }
        else{
            $savedFileName = $request->stillthumb;
         }


        $request['icon'] = $savedFileName;
        $data = $request->except('_token','_method');
        $response = $this->service->update($id, $data);
        return redirect('admin/sepeciality');

        /* $fixbanner = Specialty::find($id);
        $menuUpdate = array(
			'name'=>  $request->name,
			'details'=>  $request->details,
			'icon'=>  $savedFileName,
			'status'=>  $request->status,
			'updated_at'=> date('Y-m-d H:i:s')
		 );

        $fixbanner->update($menuUpdate);
        return redirect('admin/sepeciality'); */
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
