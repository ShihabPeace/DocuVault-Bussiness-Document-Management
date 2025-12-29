<?php

namespace App\Models;

use App\Enums\EnumsStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    /** @use HasFactory<\Database\Factories\DocumentFactory> */
    use HasFactory;

    protected $fillable = [
    'content',
    'link',
    'user',
    'checked',
    'status',
    'expires_at'
];
    protected $casts = [
        'checked' => 'boolean',
        'status' => EnumsStatus::class,
    ];

    public function actions(): HasMany
    {
        return $this->hasMany(Action::class);
    }
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
