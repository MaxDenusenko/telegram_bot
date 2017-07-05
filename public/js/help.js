function users(){

    $('#users').html(`<div class="pld_gif"><img id="pld_gif" src="../img/prld.gif" alt=""></div>`);

    $.get('users/', function (data){

        if (data == 'No users')
        {
            $('#users').html(`<div class="no_users"><p>No users</p><p>@AdamMessageBot</p></div>`);
        }
        else if (data)
        {
            $('#users').html(data);
        }
    });
}

$(document).ready(function () {
    users();
});

function closeChat(label,id) {

    $.get('closeChat',{label:label, id:id}, function (data)
    {
        if (data)
        {
            user_chats(id);
        }
    });
}

function deleteChat(label,id,status) {

    $.get('deleteChat',{label:label, id:id, status:status}, function (data)
    {
        if (data)
        {
            user_chats(id);
        }
    });
}

function user_chats(q){

    $('#container').html(`<div class="pld_gif"><img id="pld_gif" src="../img/prld.gif" alt=""></div>`);

    $.get('chats/'+q, function (data){
        if (data)
        {
            $('#container').html(data);

            $('.usersItem').removeClass('usersItemActive');

            $('.'+q).addClass('usersItemActive');

        }
        else if (data == 'error')
        {
            // user_chats(q)
            console.log('error');
        }
    });
}

var no_active_delay = 10;

var now_no_active = 0;

setInterval("now_no_active++;", 1000);

document.onclick = activeUser;

function activeUser() {

    now_no_active = 0;

    Cookies.set('active', 1);
}

setInterval(function UserStatus() {

    if (now_no_active >= no_active_delay)
    {
        Cookies.set('active', 0);
    }
},10000);


$("#sound").bind("click", function sound() {

    if (Cookies.get('sound') == 0)
    {
        $("#sound").attr("src","../img/sound.png");

        Cookies.set('sound', 1);
    }
    else
    {
        $("#sound").attr("src","../img/mute.png");

        Cookies.set('sound', 0);
    }

});


function MessagesQ(q,id){

    $('#container').html(`<div class="pld_gif"><img id="pld_gif" src="../img/prld.gif" alt=""></div>`);

    $.get('MessagesQ/'+q, function (data){
        if (data)
        {
            e = '#'+id;
            $('#container').html(data);

            var stausID = '#'+id;

            if (($(stausID).text()) && ($('#chat_status').text() == 'active'))
            {
                $(e).remove();
            }
        }
    });
}