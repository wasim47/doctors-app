<?php

use App\Http\Controllers\api\v1\AppointmentController;
use App\Http\Controllers\api\v1\BlogController;
use App\Http\Controllers\api\v1\CancelationController;
use App\Http\Controllers\api\v1\DoctorController;
use App\Http\Controllers\api\v1\HospitalController;
use App\Http\Controllers\api\v1\PatientController;
use App\Http\Controllers\api\v1\ReviewController;
use App\Http\Controllers\api\v1\ScheduleController;
use App\Http\Controllers\api\v1\SpecialtyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => '/', 'namespace' => 'api\v1'], function($route) {
    $route->post('register', [AuthController::class, 'register']);
    $route->post('login', [AuthController::class, 'login']);
    $route->get('user', [AuthController::class, 'getUser'])->middleware('jwt.auth');
    $route->post('logout', [AuthController::class, 'logout'])->middleware('jwt.auth');



    /// ALl route related of appointment
    $route->group(['prefix' => 'appointment'], function($route){
        $route->get('/', [AppointmentController::class,'index']);
    });

    /// ALl route related of blog
    $route->group(['prefix' => 'blog'], function($route){
        $route->get('/', [BlogController::class,'index']);
    });

    /// ALl route related of cancelation
    $route->group(['prefix' => 'cancelation'], function($route){
        $route->get('/', [CancelationController::class,'index']);
    });

    /// ALl route related of doctor
    $route->group(['prefix' => 'doctor'], function($route){
        $route->get('/', [DoctorController::class,'index']);
    });

    /// ALl route related of hospital
    $route->group(['prefix' => 'hospital'], function($route){
        $route->get('/', [HospitalController::class,'index']);
    });

    /// ALl route related of patient
    $route->group(['prefix' => 'patient'], function($route){
        $route->get('/', [PatientController::class,'index']);
    });

    /// ALl route related of review
    $route->group(['prefix' => 'review'], function($route){
        $route->get('/', [ReviewController::class,'index']);
    });

    /// ALl route related of specscheduleiality
    $route->group(['prefix' => 'schedule'], function($route){
        $route->get('/', [ScheduleController::class,'index']);
    });

    /// ALl route related of speciality
    $route->group(['prefix' => 'speciality'], function($route){
        $route->get('/', [SpecialtyController::class,'index']);
    });
});
