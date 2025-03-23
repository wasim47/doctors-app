<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $guarded = ['id'];

    
    public function doctor(){
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function patient(){
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function schedule(){
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
}
