<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Etudiant extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $fillable = ['user_id', 'classe_id'];
    /**
     * @return BelongsTo<User,Etudiant>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * @return BelongsToMany<Classe,Etudiant,Pivot>
     */
    public function classe(): BelongsToMany
    {
        return $this->belongsToMany(Classe::class);
    }
    /**
     * @return HasMany<Note,Etudiant>
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'etudiant_id', 'user_id');
    }
    /**
     * @return HasMany<Absence,Etudiant>
     */
    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class, 'etudiant_id', 'user_id');
    }
}
