<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    protected $table = 'note';

    protected $fillable = [
        'exam_id',
        'inscription_id',
        'valeur',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }
}
