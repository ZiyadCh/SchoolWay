<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Inscription extends Model
{
    protected $fillable = [
        'student_id',
        'year_id',
        'note_final',
        'statut',
    ];


    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolClass(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'school_class_inscription');
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(Year::class, 'year_id');
    }

    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Paiment::class);
    }


    public function exams(): BelongsToMany
    {
        return $this->belongsToMany(Exam::class, 'note')
                    ->withPivot('valeur')
                    ->withTimestamps();
    }
}
