<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\EnumsAction;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Action extends Model
{
    /** @use HasFactory<\Database\Factories\ActionFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'document_content',
        'event_type'=> EnumsAction::class,
    ];
    public function document():BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
}
