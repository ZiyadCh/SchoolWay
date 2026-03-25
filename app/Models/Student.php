<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'note_final',
    ];

    /**
     * @return HasMany<Exam,Student>
     */

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }

    /**
     * @return BelongsToMany<SchoolClass,Student,Pivot>
     */

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class);
    }

    /**
     * @return HasMany<Paiment,Student>
     */
    public function paiments(): HasMany
    {
        return $this->hasMany(Paiment::class);
    }
    /**
     * @return HasMany<Absence,Student>
     */
    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class);

    }
    /**
     * @return BelongsTo<User,Student>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }
}
