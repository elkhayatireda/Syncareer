<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['conversation_id', 'sender_id', 'content', 'file_path', 'status'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
