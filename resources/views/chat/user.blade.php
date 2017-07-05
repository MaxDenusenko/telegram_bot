@foreach($q as $k => $v)
    <li id="" class="@if(session("usersItemActive.$v->user_id")) usersItemActive @endif usersItem {{ $v->user_id }}"
        onclick="user_chats({{ $v->user_id }});">
        <div class="userImage">
            <img src="http://d3cxve53lbqhxv.cloudfront.net/images/cat_image/newappicon_1582.png" alt="">
        </div>
        <div class="userInfo">
            <div class="username">{{ $v->first_name }} {{ $v->last_name }}

                @if(isset($newMessageBD) and isset($newMessageBD['newMessage'][$v->user_id]))
                    <div id="{{ $v->user_id }}" class="countNewMessage">{{ session("NewMessage.$v->user_id") }}</div>
                @else
                    @if(isset($newMessage['newMessage'][$v->user_id]) and session("ActiveChat.$v->user_id") != 1)
                        {{ session()->put("NewMessage.$v->user_id",$newMessage['newMessage'][$v->user_id] + session("NewMessage.$v->user_id")) }}
                        {{ session()->save() }}
                        <div id="{{ $v->user_id }}" class="countNewMessage">{{ session("NewMessage.$v->user_id") }}</div>
                    @endif
                @endif

            </div>
            <div class="lastMessage">id #{{ $v->id }} | language: {{ $v->language_code }}</div>
        </div>
    </li>
@endforeach