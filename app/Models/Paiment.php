<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiment extends Model
{
    protected $table = 'paiment';
    protected $fillable = [
        'inscription_id',
        'mois',
        'etatPayement',
    ];


    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }

}
