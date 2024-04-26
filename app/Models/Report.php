<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'report',
        'patient_id',
        'doctor_id',
        'lab_rotary_id',
        'status'
    ];
}
