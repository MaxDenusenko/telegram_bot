$( document ).ready(setInterval(function q() {
    $.get('bot', function (data){
        if (data != 0)
        {
            $('#users').html(data);
            var audio = $("#audio")[0];
            if ((Cookies.get('active') == 0) && (Cookies.get('sound') == 1))
            {
                audio.play();
            }
        }
    });
},9000));