<?php

namespace App\Http\Controllers;

use App\Events\UserOffline;
use App\Events\UserOnline;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    

    public function index(Request $request)
    {
        
         $user = User::where('id','!=',  auth()->user()->id)->paginate($request->limit ?? 20);

         return view('user', [
            'data' => $user
         ]);
    }


    public function userOnline( $id) 
    {
         $user = User::find($id);
        
        $user->status = 'online';
        $user->save();

        broadcast(new UserOnline($user));


        return [
            'status' => true,
            'message' => 'User online'
        ];
    }
    
    public function userOnffline($id) 
    {
        $user = User::find($id);
        
        $user->status = 'offline';
        $user->save();

        broadcast(new UserOffline($user));


        return [
            'status' => true,
            'data' => $user,
            'message' => 'User offline'
        ];
    }



}
