<!-- resources/views/chat.blade.php -->

@extends('layouts.app')

@section('content')

<div class="container">

    <div class="list-wrapper" ng-app="app" ng-controller="MainCtrl as ctrl">
        <ul class="list">
            @foreach ($data as  $value)
            <li class="list-item">
                <a href="{{ route('convert', ['id' => $value->id]) }}" class="list-item">
                    <div>
                        <img src={{asset('photo_2023-06-09_13-23-37.jpg')}} class="list-item-image">
                      </div>
                      <div class="list-item-content">
                        <h4>{{$value->name}}</h4>
                        <p>{{$value->email}}</p>
                      </div>
                </a>
              
              </li>
            @endforeach
          
          
        </ul>
      </div>
</div>
@endsection





