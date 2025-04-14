<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatbotStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'chatbot_id',
        'status',
        'message',
    ];

    public function chatbot(): BelongsTo
    {
        return $this->belongsTo(Chatbot::class);
    }
} 