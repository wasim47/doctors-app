<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [];

    protected $guarded = ['id'];

    protected $appends = ['patient_name'];

    protected $hidden = ['first_name', 'last_name'];

    public function getPatientNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function appointments(){
        return $this->hasMany(Appointment::class, 'patient_id', 'id');
    }
}
