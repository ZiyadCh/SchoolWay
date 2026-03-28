<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiment extends Model
{
    protected $table = 'paiment';
    protected $fillable = [
        'mois',
        'etatPayement',
    ];


    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }

}
