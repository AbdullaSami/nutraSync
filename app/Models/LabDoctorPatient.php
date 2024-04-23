<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabDoctorPatient extends Model
{
    use HasFactory;
    protected $fillable = [
        'lab_rotary_id',
        'doctor_id',
        'patient_id'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function labRotary()
    {
        return $this->belongsTo(LabRotary::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
