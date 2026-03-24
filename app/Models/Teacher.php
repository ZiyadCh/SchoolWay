<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
    ];

    public function class()
    {
        return $this->hasMany(SchoolClass::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->hasOne(Subject::class);
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }
}
