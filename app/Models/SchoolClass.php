<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $fillable = [
        'name',
        'level_id',
    ];
    /**
     * @return void
     */
    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
    /**
     * @return void
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    /**
     * @return void
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }


}
