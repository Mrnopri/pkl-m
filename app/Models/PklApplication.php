<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PklApplication extends Model
{
    protected $fillable = [
        'user_id',
        'education_level',
        'institution_name',
        'major',
        'nim',
        'start_date',
        'end_date',
        'file_path',
        'status',
        'unit_id',
        'supervisor_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }
}
