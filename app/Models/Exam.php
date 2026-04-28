<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exam extends Model
{
    protected $fillable = [
        'title',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function inscriptions(): BelongsToMany
    {
        return $this->belongsToMany(Inscription::class, 'note')
                    ->withPivot('valeur')
                    ->withTimestamps();
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
