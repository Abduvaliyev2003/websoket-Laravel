<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conversation extends Model
{
    use HasFactory;



    protected $fillable = 
    [
        'sender_id',
        'receiver_id',
        'last_time_message'
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function sender()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
