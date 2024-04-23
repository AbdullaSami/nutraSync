<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'user_id',
        'report',
        'gender',
        'owner',
        'clinic',
        'personal_id',
        'license_number',
        'tax_number',
        'doctor_papers',
        'personal_image',
    ];

    public function lab()
    {
        return $this->belongsTo(LabRotary::class);
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'lab_doctor_patient');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($doctor) {
            $doctor->doctor_id = 'DOC' . str_pad(Doctor::count() + 1, 5, '0', STR_PAD_LEFT);
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
