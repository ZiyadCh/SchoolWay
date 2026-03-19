<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiment extends Model
{
    protected $fillable = [
        'mois',
        'etatPayement',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }
}
