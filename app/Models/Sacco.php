<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Sacco extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function stations(): HasMany
    {
        return $this->hasMany(Station::class);
    }

    public function charges(): HasMany
    {
        return $this->hasMany(Charge::class);
    }

    public function vehicles(): HasManyThrough
    {
        return $this->hasManyThrough(Vehicle::class, Station::class);
    }

    public function officials(): Collection
    {
        return $this->users()->wherePivot('role_id', 2)->get();
    }

    public function operators(): Collection
    {
        return $this->users()->wherePivot('role_id', 3)->get();
    }
}
