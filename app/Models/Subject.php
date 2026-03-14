<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'title',
    ];
    public function teacher()
    {
        return $this->hasMany(Subject::class);
    }
}
