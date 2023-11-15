<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    
    public function chatlist()  {
         
        $user =  auth()->user()->id;

        $conventor = Conversation::with('user' , 'sender','user.messages')->where('sender_id', $user)->orWhere('receiver_id', $user)->orderBy('last_time_message', 'DESC')->get();


      
        return  $conventor;
    }




    public function create($id){
       
        $sender_id = $id;
        $user =  auth()->user()->id;
        $checkConversation  = Conversation::where('receiver_id', $user )->where('sender_id', $sender_id)->orWhere('receiver_id', $sender_id)->orWhere('sender_id', $user)->get();
       
        if(count($checkConversation) == 0){
        
            $createConversation = Conversation::query()->create([
                 'receiver_id' => $user,
                 'sender_id' => $sender_id,
               
            ]);

            $createdMessage = Message::query()->create([
                 'conversation_id'=> $createConversation->id,
                 'user_id' => $user,
                 'receriver_id' => $sender_id,
                 'message' => "hello",
            ]);

            $createConversation->last_time_message = $createdMessage->created_at;
            $createConversation->save();
        } elseif(count($checkConversation) >= 1) {
          $dd =   Conversation::where('receiver_id', $user )->where('sender_id', $sender_id)->first();
          if($dd == null){
            $createConversation = Conversation::query()->create([
                'receiver_id' => $user,
                'sender_id' => $sender_id,
           ]);

           $createdMessage = Message::query()->create([
                'conversation_id'=> $createConversation->id,
                'user_id' => $user,
                'receriver_id' => $sender_id,
                'message' => "hello",
           ]);

           $createConversation->last_time_message = $createdMessage->created_at;
           $createConversation->save();
            
          }  
            
           
        }


        return  redirect()->route('chat');
        
    }
}
