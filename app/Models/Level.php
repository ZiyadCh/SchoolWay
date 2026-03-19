<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = [
        'title',
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
