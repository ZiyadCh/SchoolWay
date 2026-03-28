<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Student extends Model
{
    protected $fillable = [
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    public function classes(): HasManyThrough
    {
        return $this->hasManyThrough(
            SchoolClass::class,
            Inscription::class,
            'student_id',
            'id',
            'id',
            'school_class_id'
        );
    }

    public function paiments(): HasManyThrough
    {
        return $this->hasManyThrough(Paiment::class, Inscription::class);
    }

    public function absences(): HasManyThrough
    {
        return $this->hasManyThrough(Absence::class, Inscription::class);
    }

    public function exams(): HasManyThrough
    {
        return $this->hasManyThrough(Exam::class, Inscription::class);
    }

    public function activeInscription()
    {
        return $this->hasOne(Inscription::class)->where('statut', 'active')->latest();
    }
}
