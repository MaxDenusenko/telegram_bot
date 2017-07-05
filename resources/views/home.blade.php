@extends('layouts.app')

@section('content')
    <div class="wrapper" id="app">
        <div class="top">
            <a href="#">@AdamMessageBot</a>
            <img id="sound" src="@if($_COOKIE["sound"] == 1){{ asset('img/sound.png') }}@else{{ asset('img/mute.png') }}@endif" alt="sound" title="Sound message">
            <a class="text-color" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
        <div class="content">
            <div class="users">
                <ul id="users"></ul>
            </div>
            <div class="container" id="container"></div>
        </div>
    </div>
@endsection

