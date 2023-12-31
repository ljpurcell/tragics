<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchDay extends Model
{
    public $timestamps = false;
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongTo(User::class);
    }
}
