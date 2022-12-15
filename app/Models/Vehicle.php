<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    public function operators(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
