<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Charge extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sacco(): BelongsTo
    {
        return $this->belongsTo(Sacco::class);
    }
}
