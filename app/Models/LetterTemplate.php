<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class LetterTemplate extends Model
{
    protected $fillable = [
        'name',
        'description',
        'template_file_path',
        'content',
        'default_fields',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'default_fields' => 'array',
        'is_active' => 'boolean',
    ];

    // Relationship to User (creator)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relationship to Letters
    public function letters()
    {
        return $this->hasMany(Letter::class);
    }
}
