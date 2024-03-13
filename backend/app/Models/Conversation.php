<?php

namespace App\Models;

use App\Models\User;
use App\Models\Company;
use App\Models\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversation extends Model
{
    use HasFactory;
    protected $fillable = ['user1_id', 'user2_id'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }
    public function messages()
    {
        return $this->belongsTo(Message::class,'conversation_id');
    }
}
