<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'inscription_id',
        'student_id',
        'status',
        'note',
        'date',
    ];


    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }

}
