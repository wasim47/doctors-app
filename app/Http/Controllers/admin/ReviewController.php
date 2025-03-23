<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ReviewStoreRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Services\ReviewService;

class ReviewController extends BaseController
{

    protected $service;

    public function __construct(ReviewService $service)
    {
        $this->service = $service;
        
    }

    /**
     * @OA\Get(
     *     path="/api/review",
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */

    //// Get all Speciality form app
    public function index(){
        
        // return response()->json($this->service->index(), 200);
        return ReviewResource::collection($this->service->index());
    }


    // Add new specialty with custom validation rules
    public function store(ReviewStoreRequest $request){

        // return response()->json($this->service->store($request->all()), 201);
        return new ReviewResource($this->service->store($request->all()));
    }
}
