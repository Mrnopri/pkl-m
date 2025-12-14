<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Letter extends Model
{
    protected $fillable = [
        'letter_template_id',
        'letter_number',
        'recipient_name',
        'reference_number',
        'reference_date',
        'letter_date',
        'purpose',
        'duration',
        'start_date',
        'end_date',
        'pkl_start_date',
        'signatory_name',
        'signatory_position',
        'signatory_nik',
        'signature_path',
        'custom_data',
        'generated_content',
        'pdf_path',
        'created_by',
    ];

    protected $casts = [
        'custom_data' => 'array',
        'letter_date' => 'date',
        'reference_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'pkl_start_date' => 'date',
    ];

    // Relationship to LetterTemplate
    public function template()
    {
        return $this->belongsTo(LetterTemplate::class, 'letter_template_id');
    }

    // Relationship to User (creator)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relationship to PKL Applications (students) through pivot
    public function participants()
    {
        return $this->belongsToMany(PklApplication::class, 'letter_participants', 'letter_id', 'pkl_application_id')
            ->withTimestamps();
    }
}
