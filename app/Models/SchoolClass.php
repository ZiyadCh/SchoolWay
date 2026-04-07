<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolClass extends Model
{
    protected $fillable = [
        'name',
        'level_id',
        'teacher_id',
        'nbr_students',
    ];

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function devoirs(): HasMany
    {
        return $this->hasMany(Devoir::class, 'school_class_id');
    }

    public function subject()
    {
        return $this->hasOne(Subject::class);
    }

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    public function students(): HasManyThrough
    {
        return $this->hasManyThrough(
            Student::class,
            Inscription::class,
            'school_class_id',
            'id',
            'id',
            'student_id'
        );
    }

    public function exams(): HasManyThrough
    {
        return $this->hasManyThrough(Exam::class, Inscription::class);
    }

    public function absences(): HasManyThrough
    {
        return $this->hasManyThrough(Absence::class, Inscription::class);
    }


}
