<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Devoir extends Model
{
    protected $table = 'devoir';
    protected $fillable = [
        'school_class_id',
        'title',
        'contenu',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }

}
