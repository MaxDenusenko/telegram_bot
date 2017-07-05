<ul class="chatsWindow">
    @foreach($chats as $k => $v)
        <div class="chat_container">
        <li class="usersItem " onclick="MessagesQ('{{ $v->chat_label }}','{{ $v->chat_id }}');">
            <div class="US">
                <div class="userImage">
                    <img src="http://d3cxve53lbqhxv.cloudfront.net/images/cat_image/newappicon_1582.png" alt="">
                </div>
                <div class="userInfo">
                    <div class="username dateCreateChat">Create : {{ $v-> created_at}} @if($v->status == 'active')
                            <div class="status">{{ $v->status }}</div>@endif</div>

                    @if(isset($lastMessage[$v->chat_label]))
                        <div class="lastMessage"><span class="spanSender">{{ $lastMessage[$v->chat_label] }} </span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="chatStatus">
                {{--@if($v->status == 'active')--}}
                    {{--<div class="status close" onclick="closeChat('{{ $v->chat_label }}','{{ $v->chat_id }}');">close--}}
                    {{--</div>--}}
                {{--@endif--}}
                {{--<div class="status delete"--}}
                     {{--onclick="deleteChat('{{ $v->chat_label }}','{{ $v->chat_id }}','{{ $v->status }}');">delete--}}
                {{--</div>--}}
            </div>
        </li>
        @if($v->status == 'active')
            <div class="close" onclick="closeChat('{{ $v->chat_label }}','{{ $v->chat_id }}');">Close</div>
        @endif
        <div class="delete" onclick="deleteChat('{{ $v->chat_label }}','{{ $v->chat_id }}','{{ $v->status }}');">Delete</div>
        </div>
    @endforeach
</ul>

