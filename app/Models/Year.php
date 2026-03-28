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
    ];

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    public static function currentYear()
    {
        return self::where('current', true)->first();
    }
}
