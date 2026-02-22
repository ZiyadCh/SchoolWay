<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Maitre extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $fillable = ['user_id', 'matiere'];
    /**
     * @return HasMany<Devoir,Maitre>
     */
    public function devoirs(): HasMany
    {
        return $this->hasMany(Devoir::class, 'maitre_id', 'user_id');
    }
}
