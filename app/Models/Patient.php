<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patient_id',
        'personal_id',
        'personal_image',
        'personal_id_front',
        'personal_id_back',
        'date_of_birth',
        'gender',
        'height',
        'weight',
        'muscles_percentage',
        'total_body_fat',
        'total_body_water',
        'bmi'
    ];

    public function lab()
    {
        return $this->belongsTo(LabRotary::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            $patient->patient_id = 'PAT' . str_pad(Patient::count() + 1, 5, '0', STR_PAD_LEFT);
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
