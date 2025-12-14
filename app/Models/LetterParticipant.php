<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class LetterParticipant extends Model
{
    protected $fillable = [
        'letter_id',
        'pkl_application_id',
    ];

    // Relationship to Letter
    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }

    // Relationship to PKL Application
    public function pklApplication()
    {
        return $this->belongsTo(PklApplication::class);
    }
}
