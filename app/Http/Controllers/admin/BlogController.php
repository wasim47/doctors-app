<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\BlogStoreRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Services\BlogService;

class BlogController extends BaseController
{

    protected $service;

    public function __construct(BlogService $service)
    {
        $this->service = $service;
        
    }

    /**
     * @OA\Get(
     *     path="/api/blog",
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    
    //// Get all Speciality form app
    public function index(){
        
        // return response()->json($this->service->index(), 200);
        return BlogResource::collection($this->service->index());
    }


    // Add new specialty with custom validation rules
    public function store(BlogStoreRequest $request){

        // return response()->json($this->service->store($request->all()), 201);
        return new BlogResource($this->service->store($request->all()));
    }
}
