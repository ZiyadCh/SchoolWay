<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Inscription extends Model
{
    protected $fillable = [
        'student_id',
        'school_class_id',
        'year_id',
        'note_final',
        'statut',
    ];


    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class, 'year_id');
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Paiment::class);
    }
}
