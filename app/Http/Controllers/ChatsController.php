<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\MessageUpdated;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{
    



public function __construct()
{
  $this->middleware('auth');
}

/**
 * Show chats
 *
 * @return \Illuminate\Http\Response
 */
public function index()
{
  return view('chat');
}

/**
 * Fetch all messages
 *
 * @return Message
 */
public function fetchMessages($id,  $user_id)
{  
   $message =  Message::with('user')->where('conversation_id', $id)->get();
   $user = User::where('id', $user_id )->first();
  return  [
           'message' =>   $message,
            'user' => $user 
         ];
}

/**
 * Persist message to database
 *
 * @param  Request $request
 * @return Response
 */
public function sendMessage(Request $request)
{
  $request->validate([
      'receriver_id' => 'required|integer',
      'conversation_id'=> 'required|integer'
  ]);
  $user = Auth::user();
  if ($request->hasFile('audio')) {
    $audioFile = $request->file('audio');
    $fileName = time() . '_audio.mp3';

    // Audio faylni serverga saqlash
    $audioFile->storeAs('audio', $fileName, 'public');

    // Fayl manzilini oling
    $fileUrl = env('APP_URL') . '/storage/audio/' . $fileName;
    $message = $user->messages()->create([
      'receriver_id' => $request->input('receriver_id'),
      'conversation_id' => $request->input('conversation_id'),
      'audio' => $fileUrl
    ]);

    broadcast(new MessageSent($user, $message, $message->id))->toOthers();
    return ['status' => 'Message Sent!'];
  }
  $message = $user->messages()->create([
    'message' => $request->input('message') ?? null,
    'receriver_id' => $request->input('receriver_id'),
    'conversation_id' => $request->input('conversation_id'),
  ]);
  broadcast(new MessageSent($user, $message, $message->id))->toOthers();
  return ['status' => 'Message Sent!'];
}


public function updateMessage(Request $request)
{
    $request->validate([
      'message_id' => 'required|integer',
      'user_id' => 'required|integer',
      'message' => 'required'
    ]);
    $user = Auth::user();

    if($request->user_id == $user->id){
       $updateMessage = Message::query()->where('id', $request->message_id)->first();
      if($updateMessage !== null) {
        $message = Message::findOrFail($request->message_id);
        $message->message = $request->input('message');
        $message->save();

        // Fire the MessageUpdated event
        broadcast(new MessageUpdated($message, auth()->user(), $message->id));
        return [
          'status' => true,
          'message' => $updateMessage
        ];
      } 
      return [
        'status' => false,
        'message' => 'Message not found'
      ];

    } 
    
    return [
      'status' => false,
      'message' => 'not updated your message'
    ];

}


}
