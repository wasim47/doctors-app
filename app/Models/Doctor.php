<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [];

    protected $guarded = ['id'];

    protected $appends = ['doctor_name'];

    protected $hidden = ['first_name', 'last_name'];

    public function getDoctorNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function appointments(){
        return $this->hasMany(Appointment::class, 'doctor_id', 'id');
    }

    public function specialities()
    {
        return $this->belongsToMany(Specialty::class, 'doctor_specialities', 'doctor_id', 'speciality_id');
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'doctor_branches', 'doctor_id', 'branch_id');
    }

    public function schedule(){
        return $this->hasMany(Schedule::class, 'doctor_id', 'id');
    }
}
