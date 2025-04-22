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
use App\Services\UtilityService;

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
        $this->app->bind(UtilityService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       //
    }
}
