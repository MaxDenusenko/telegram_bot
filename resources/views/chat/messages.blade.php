<div class="info_chat">
    @foreach($message as $k => $v)
        <div id="chat_id" style="visibility: hidden;">{{ $v->chat_id }}</div>
        <div id="chat_label" style="visibility: hidden;">{{ $v->chat_label }}</div>
        @if(isset($status))
            <div id="chat_status" style="visibility: hidden;">{{ $status }}</div>
        @endif
        @break
    @endforeach
</div>
<div class="chatWindow">
    <ul id="chatWindow">
        @foreach($message as $k => $v)
            @if ( $v->sender != 'You' )
                <li class="message margin_left">
                    <img class="messageImageUser"
                         src="http://d3cxve53lbqhxv.cloudfront.net/images/cat_image/newappicon_1582.png" alt="">
                    <span class="messageItem"><span class="date">{{  $v->created_at }}</span>{{  $v->text }}</span>
                </li>
            @else
                <li class="message flex-align-right">
                    <span class="messageItem messageItemRight"><span class="date">{{  $v->created_at }}</span>{{  $v->text }}</span>
                    <img class="messageImageUser help_margin_image_chat"
                         src="http://d3cxve53lbqhxv.cloudfront.net/images/cat_image/newappicon_1582.png" alt="">
                </li>
            @endif
        @endforeach
    </ul>
</div>
@if(!empty($status))
    <div class="sendMessage">
        <input type="text" placeholder="Message" id="textarea" required></input>
    </div>
@endif
