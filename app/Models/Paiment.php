<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiment extends Model
{
    protected $table = 'paiment';
    protected $fillable = [
        'inscription_id',
        'mois',
        'etatPaiement',
    ];


    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }

}
