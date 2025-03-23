<?php

namespace App\Providers;

// All dependency for API
use Illuminate\Support\ServiceProvider;
use App\Repositories\AppointmentRepository;
use App\Repositories\AppointmentRepositoryInterface;
use App\Repositories\SpecialtyRepository;
use App\Repositories\SpecialtyRepositoryInterface;
use App\Repositories\BlogRepository;
use App\Repositories\BlogRepositoryInterface;
use App\Repositories\DoctorRepository;
use App\Repositories\DoctorRepositoryInterface;
use App\Repositories\PatientRepository;
use App\Repositories\PatientRepositoryInterface;
use App\Repositories\ScheduleRepository;
use App\Repositories\ScheduleRepositoryInterface;
use App\Repositories\ReviewRepository;
use App\Repositories\ReviewRepositoryInterface;
use App\Repositories\CancelationRepository;
use App\Repositories\CancelationRepositoryInterface;
use App\Repositories\HospitalRepository;
use App\Repositories\HospitalRepositoryInterface;
use App\Repositories\BranchRepository;
use App\Repositories\BranchRepositoryInterface;
use App\Repositories\CommonRepository;
use App\Repositories\CommonRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;

// All dependency for Admin
/* use App\Repositories\Admin\AdminAppointmentRepository;
use App\Repositories\Admin\AdminAppointmentRepositoryInterface;
use App\Repositories\Admin\AdminSpecialtyRepository;
use App\Repositories\Admin\AdminSpecialtyRepositoryInterface;
use App\Repositories\Admin\AdminBlogRepository;
use App\Repositories\Admin\AdminBlogRepositoryInterface;
use App\Repositories\Admin\AdminDoctorRepository;
use App\Repositories\Admin\AdminDoctorRepositoryInterface;
use App\Repositories\Admin\AdminPatientRepository;
use App\Repositories\Admin\AdminPatientRepositoryInterface;
use App\Repositories\Admin\AdminScheduleRepository;
use App\Repositories\Admin\AdminScheduleRepositoryInterface;
use App\Repositories\Admin\AdminReviewRepository;
use App\Repositories\Admin\AdminReviewRepositoryInterface;
use App\Repositories\Admin\AdminCancelationRepository;
use App\Repositories\Admin\AdminCancelationRepositoryInterface;
use App\Repositories\Admin\AdminHospitalRepository;
use App\Repositories\Admin\AdminHospitalRepositoryInterface; */

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // All dependency for API
        $this->app->bind(SpecialtyRepositoryInterface::class, SpecialtyRepository::class);
        $this->app->bind(BlogRepositoryInterface::class, BlogRepository::class);
        $this->app->bind(PatientRepositoryInterface::class, PatientRepository::class);
        $this->app->bind(DoctorRepositoryInterface::class, DoctorRepository::class);
        $this->app->bind(ScheduleRepositoryInterface::class, ScheduleRepository::class);
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
        $this->app->bind(CancelationRepositoryInterface::class, CancelationRepository::class);
        $this->app->bind(AppointmentRepositoryInterface::class, AppointmentRepository::class);
        $this->app->bind(HospitalRepositoryInterface::class, HospitalRepository::class);
        $this->app->bind(BranchRepositoryInterface::class, BranchRepository::class);
        $this->app->bind(CommonRepositoryInterface::class, CommonRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       //
    }
}
