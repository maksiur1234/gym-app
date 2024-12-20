<?php

namespace App\Models\Message;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;
    public $table = 'messages';
    protected $fillable = ['id', 'user_id', 'receiver_id', 'text', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function getTimeAttribute(): string
    {
        return date(" d M Y, H:i:s", strtotime($this->attributes['created_at']));
    }
}
