<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = [
        'name',
    ];

    public function classes()
    {
        return $this->hasMany(SchoolClass::class);
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }
}
