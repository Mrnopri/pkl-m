<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['name', 'quota'];

    public function applications()
    {
        return $this->hasMany(PklApplication::class);
    }
}
