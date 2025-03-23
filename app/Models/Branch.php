<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [];

    protected $guarded = ['id'];

    protected $hidden = ['pivot'];

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_branches', 'branch_id', 'doctor_id');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id', 'id');
    }
}
