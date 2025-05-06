<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientDocument extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [];

    protected $guarded = ['id'];

    public function patient(){
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function patientFamily(){
        return $this->belongsTo(PatientFamily::class, 'patient_family_id', 'id');
    }

    public function files(){
        return $this->hasMany(PatientDocumentFile::class, 'document_id', 'id');
    }
}
