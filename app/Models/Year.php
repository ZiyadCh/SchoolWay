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
}
