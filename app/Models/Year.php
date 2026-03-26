<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    $protected $table = 'academic_year';
    protected $fillable = [
        'title',
        'beginning_date',
        'end_date',
    ];

    public function classes()
    {
        return $this->hasMany(SchoolClass::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
