<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatConversation extends Model
{
    protected $table = "chat_conversations";

    protected $fillable = [
        'role',
        'content',
        'intent',
        'conversation_id',
    ];

}
