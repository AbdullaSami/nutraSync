<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabRotary extends Model
{
    use HasFactory;

    protected $fillable = [
        'lab_rotary_id',
        'user_id',
        'analysis',
        'name',
        'contact_person',
        'contact_number',
        'tax_number',
        'lab_papers',
        'logo',
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($labRotary) {
            $labRotary->lab_rotary_id = 'LAB' . str_pad(LabRotary::count() + 1, 5, '0', STR_PAD_LEFT);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
