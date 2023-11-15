<!-- resources/views/chat.blade.php -->

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="">
            <div class="panel panel-default">
                {{-- <div class="panel-heading">Chats</div> --}}
                <div class="panel-con">

                     <div class="chat-list">
                        <chat-list :chat-list="chatList" :arrayon="arrayOn" :convertid="convertid" :users="users"  :typewrite="typeWrite" @addchatlist="fetchMessages" :user="{{ Auth::user() }}"> </chat-list>
                     </div>
                     <div class="rigths msger-chat">
                         <profile-user :userob="user_ob"></profile-user>
                        <div class="panel-body" ref="messageContainer">
                            <chat-messages    @edittext="editCreate" :userob="user_ob"  :typewrite="typeWrite"  :messages="messages" :user="{{ Auth::user() }}" :convertid="convertid" :channel="convert" ></chat-messages>
                        </div>
                        <div class="panel-footer">
                            <chat-form
                                v-on:messagesent="addMessage"
                                v-on:update="updatedMessage"
                                @storeaudio="startRecording"
                                @stopaudio="stopRecording"
                                @getvale="inputValue"
                                :user="{{ Auth::user() }}" 
                                :senderid="resiver" 
                                :channel="convert"
                                :updatebtn="updateBtn"
                                :updateob="updateObjectv"
                            ></chat-form>
                        </div>
                     </div>
                   

                </div>
              
            </div>
        </div>
    </div>
</div>
@endsection

