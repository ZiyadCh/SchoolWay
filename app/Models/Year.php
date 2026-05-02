<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Year extends Model
{
    protected $table = 'academic_year';
    protected $fillable = [
        'title',
        'beginning_date',
        'end_date',
        'current',
        'selected',
    ];

    public function classes(): HasMany
    {
        return $this->hasMany(SchoolClass::class);
    }

    //////////////
    //to return the current working year to insert in other places
    public static function currentYear()
    {
        return self::where('current', true)->first();
    }

    //return the selected year to show data related to that year
    public static function selectedYear()
    {
        return self::where('selected', true)->first();
    }
}
