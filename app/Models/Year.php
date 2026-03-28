<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $table = 'academic_year';
    protected $fillable = [
        'title',
        'beginning_date',
        'end_date',
        'current',
    ];

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    //////////////
    //to return the current working year to insert in other places
    public static function currentYear()
    {
        return self::where('current', true)->first();
    }
}
