<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSpeciality extends Model
{
    use HasFactory;
    protected $fillable = [];

    protected $guarded = ['id'];

    public function doctor(){
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function specility(){
        return $this->belongsTo(Specialty::class, 'speciality_id');
    }
}
