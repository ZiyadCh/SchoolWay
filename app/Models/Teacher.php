<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'subject_id',
    ];

    public function class()
    {
        return $this->hasMany(SchoolClass::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
