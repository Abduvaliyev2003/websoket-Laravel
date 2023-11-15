<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;


    // app/Message.php

/**
 * Fields that are mass assignable
 *
 * @var array
 */
protected $guarded  = [];



/**
 * A message belong to a user
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function user():BelongsTo
{
  return $this->belongsTo(User::class, 'user_id' );
}


public function conversation():BelongsTo
{
     return $this->belongsTo(Conversation::class,  'conversation_id' );
}


}
