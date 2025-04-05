<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorExperience extends Model
{
    use HasFactory;
    protected $fillable = [];

    protected $guarded = ['id'];

    public function doctor(){
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
