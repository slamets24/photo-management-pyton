<?php

namespace App\Models;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'image',
        'pass_event',
        'slug',
        'user_id',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
