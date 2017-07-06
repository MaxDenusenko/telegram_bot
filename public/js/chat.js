$(document).ready(function ()
{

    $(document).keydown(function (e)
    {
        var chat_id = $('div#chat_id').text();

        var chat_label = $('div#chat_label').text();

        if($("#textarea").length>0)
        {
            var el = $('#textarea');

            if (el.is(":focus")){
                if (e.which == 13)
                {
                    sendMessages(chat_id, chat_label);
                }
            }

        }
    });
});

function sendMessages(chat_id, chat_label)
{

    if($("#textarea").length>0)
    {
        var text = $('#textarea').val();

        if (text.length > 0)
        {

            $.get('sendMessage',{text:text, chat_id:chat_id, chat_label:chat_label}, function () {
                $('#chatWindow').append(`
                                        <li class="message flex-align-right">
                                            <span class="messageItem messageItemRight">`+ text +`</span>
                                            <img class="messageImageUser help_margin_image_chat" src="http://d3cxve53lbqhxv.cloudfront.net/images/cat_image/newappicon_1582.png" alt="">
                                        </li>
                                        `);
                $('#textarea').val('');
            });
        }
    }
}


setInterval(retrieveChatMessages,7000);

function retrieveChatMessages() {

    if(($("#chat_id").length>0) && ($('#chat_status').text() == 'active'))

    {
            var chat_id = $('#chat_id').text();

            $.get('retrieveChatMessages',{chat_id:chat_id}, function (data) {

                if (data !== '0' )
                {
                    var chat_label = $('#chat_label').text();

                    var j_data = JSON.parse(data);
                    for (var i = 0; i < j_data.length; i++) {
                        if (chat_label == j_data[i].chat_label) {

                            e = '#'+ $('#chat_id').text();
                            $(e).remove();

                            $('#chatWindow').append
                            (`
                              <li class="message margin_left">
                                    <img class="messageImageUser" src="http://d3cxve53lbqhxv.cloudfront.net/images/cat_image/newappicon_1582.png" alt="">
                                    <span class="messageItem"><span class="date">` + j_data[i].created_at + `</span>` + j_data[i].text + `</span>
                              </li>
                            `);

                        }
                    }
                }
            });
    }
}
