<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public function class()
    {
        return $this->belongsTo(SchoolClass::class);
    }
}
