<?php

namespace App\Http\Controllers;

use App\Chats;
use App\Messages;
use App\User;
use App\UsersChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Telegram\Bot\Api;
use Illuminate\Support\Facades\DB;

class IndexController extends MainController
{
    public $offset;

    public $newMessage = ['newMessage' => 0];

    public $lastMessage = [];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param UsersChat $UsersChatModel
     * @param Chats $ChatsModel
     * @param Messages $MessagesModel
     * @return int/view
     */
    public function bot(UsersChat $users_chat_model, Chats $chats_model, Messages $messages_model)
    {
        $response = $this->telegramBotToken->getUpdates();

        if (!empty($response[0]['update_id'])) {
            foreach ($response as $k => $v) {
                $user_id       = @$v['message']['from']['id']?:"";
                $first_name    = @$v['message']['from']['first_name']?:"";
                $last_name     = @$v['message']['from']['last_name']?:"";
                $language_code = @$v['message']['from']['language_code']?:"";

                $chat_id       = $v['message']['chat']['id'];
                $type          = @$v['message']['chat']['type']?:"";
                $status        = 'active';

                $text          = @$v['message']['text']?:"resources";
                $date          = $v['message']['date'];

                $user = $users_chat_model->getUser($user_id);

                if ($user -> isEmpty()) {
                    $users_chat_model->createUser($user_id, $first_name, $last_name, $language_code);

                    $chat_label = md5($date);

                    $chats_model->createChat($chat_id, $chat_label, $type, $status);
                }

                $c_l = $chats_model->selectChatLabel($status, $user_id);

                if ($c_l -> isEmpty()) {
                    $chat_label = md5($date);

                    $chats_model->createChat($chat_id, $chat_label, $type, $status);
                } else {
                    foreach ($c_l as $key => $value)
                    {
                        $chat_label = $value->chat_label;
                    }
                }

                $messages_model->createMessage($chat_id, $chat_label, $text , $first_name, false);

                $this->offset++ ;

                $this->newMessage['newMessage'] = [$chat_id => $this->newMessage['newMessage'][$chat_id]+1];

            }

            $this->offset = $response[0]['update_id'] + $this->offset;

            $this->telegramBotToken->getUpdates(['offset' => $this->offset]);

            $users_Chat = $users_chat_model->selectUsers();

            return view('chat/user')->with(['q' => $users_Chat,'newMessage' => $this->newMessage]);
        }
        return 0;
    }

    /**
     * @param UsersChat $UsersChatModel
     * @param Messages $MessagesModel
     * @return string/view
     */
    public function users (UsersChat $users_chat_model, Messages $messages_model)
    {
        $UsersChat = $users_chat_model->selectUsers();

        if ($UsersChat -> isNotEmpty()) {
            $new_Messages = $messages_model->selectAllNewMessages();

            foreach ($new_Messages as $k => $v) {
                $this->newMessage['newMessage'] = [$v->chat_id => $this->newMessage['newMessage'][$v->chat_id]+1];
            }
            return view('chat/user')->with(['q' => $UsersChat,'newMessageBD' => $this->newMessage]);
        }
        return 'No users';
    }

    /**
     * @param Request $request
     * @param Chats $ChatsModel
     * @param Messages $MessagesModel
     * @param $chat_id
     * @return bool/view
     */
    public function chats(Request $request, Chats $chats_model, Messages $messages_model,$chat_id)
    {
        $request->session()->forget("usersItemActive");

        $request->session()->put("usersItemActive.$chat_id",1);

        $request->session()->save();

        $chats = $chats_model->selectChats($chat_id);

        if (!$chats -> isEmpty()) {
            foreach ($chats as $k => $v) {
                $last_Message = $messages_model->selectLastMessage($v->chat_label);

                $last_Message->text = $messages_model->textValidation($last_Message->text,0,60);

                $this->lastMessage[$last_Message->chat_label] = $last_Message->sender. ': ' .$last_Message->text;
            }
            return view('chat/chat')->with(['chats' => $chats, 'lastMessage' => $this->lastMessage]);
        } else {
            return false;
        }
    }

    /**
     * @param Request $request
     * @param Chats $ChatsModel
     * @param Messages $MessagesModel
     * @param $chat_label
     * @return bool/view
     */
    public function messages(Request $request, Chats $chats_model, Messages $messages_model, $chat_label)
    {
        $message = $messages_model->selectMessage($chat_label);

        if (!$message -> isEmpty()) {
            $messages_model->updateStatusMessage($chat_label);

            $active_chat = $chats_model->selectActiveChat($chat_label);

            if ($active_chat -> isNotEmpty()) {
                foreach ($active_chat as $k => $v) {
                    $request->session()->put("NewMessage.$v->chat_id",0);

                    $request->session()->save();
                }
                return view('chat/messages')->with(['message' => $message, 'status' => 'active']);
            }
            return view('chat/messages')->with(['message' => $message]);
        }

        return false;
    }

    /**
     * @param Messages $MessagesModel
     */
    public function sendMessage(Messages $messages_model)
    {
        $chat_id = Input::get('chat_id');

        $chat_label = Input::get('chat_label');

        $text = Input::get('text');

        $messages_model->send($this->telegramBotToken, $chat_id, $chat_label, $text);
    }

    /**
     * @param Request $request
     * @param Messages $MessagesModel
     * @return string
     */
    public function retrieveChatMessages(Request $request, Messages $messages_model)
    {
        $chat_id = Input::get('chat_id');

        $messages = $messages_model->selectNewMessages($chat_id);

        if ($messages -> isNotEmpty()) {
            $request->session()->put("NewMessage.$chat_id",0);

            $request->session()->save();

            $Chat = new Messages();

            $Chat->chat_id = $chat_id;

            $Chat->saveReadMessages();

            return json_encode($messages);
        }
        return '0';
    }

    /**
     * @param Request $request
     * @param Chats $ChatsModel
     * @param Messages $MessagesModel
     * @return int
     */
    public function closeChat(Request $request, Chats $chats_model, Messages $messages_model)
    {
        $chat_label = Input::get('label');

        $chat_id = Input::get('id');

        $close_Chat = $chats_model->updateChatStatus_NoActive($chat_label);

        if ($close_Chat) {
            $new_Label = md5($chat_id.str_random(10));

            $messages_model->updateMessage_Status_Label($chat_label,$new_Label);

            if (session("ActiveChat.$chat_id")) {
                $request->session()->forget("ActiveChat.$chat_id");

                $request->session()->save();
            }

            $chats_model->createChat($chat_id, $new_Label, 'private', 'active');

            $messages_model->createMessage($chat_id, $new_Label, '/start', 'You', 1);

            return 1;
        }

        return 0;
    }

    /**
     * @param Request $request
     * @param Chats $ChatsModel
     * @param Messages $MessagesModel
     * @return int
     */
    public function deleteChat(Request $request, Chats $chats_model, Messages $messages_model)
    {
        $chat_label = Input::get('label');

        $chat_id = Input::get('id');

        $status = Input::get('status');

        $del_Chat = $chats_model->deleteChat($chat_label);

            if ($del_Chat) {
                $del_Message = $messages_model->deleteMessage($chat_label);

                if ($del_Message) {

                    if ($status == 'active') {
                        $new_Label = md5($chat_id.str_random(10));

                        $chats_model->createChat($chat_id, $new_Label, 'private', 'active');

                        $messages_model->updateMessage_Status_Label($chat_label,$new_Label);

                        $messages_model->createMessage($chat_id, $new_Label, '/start', 'You', 1);
                    }

                    return 1;
                }

            }

            return 0;
    }
}
