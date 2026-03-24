<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
    ];
    public function teacher()
    {
        return $this->hasMany(Subject::class);
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }
}
