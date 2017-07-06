<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Telegram\Bot\Api;

class Messages extends Model
{
    protected $table = 'Messages';

    protected $fillable = ['chat_id','chat_label','text', 'sender', 'read'];

    public $text;

    public $chat_id;

    public $chat_label;

    public function deleteMessage($chat_label)
    {
        return \DB::table('Messages')->where('chat_label', '=', $chat_label)->where('read','=','1')->delete();
    }

    public function updateMessage_Status_Label($chat_label,$newLabel)
    {
        return \DB::table('Messages')->where('chat_label', '=', $chat_label)->where('read', '=', 0)->update(['chat_label' => $newLabel, 'read' => 1]);
    }

    public  function selectNewMessages($chat_id)
    {
        return \DB::table('Messages')->where('chat_id','=', $chat_id)->where('read', '=', '0')->get();
    }

    public function updateStatusMessage($chat_label)
    {
        return \DB::table('Messages')->where('chat_label', '=', $chat_label)->update(['read' => '1']);
    }

    public function selectMessage($chat_label)
    {
        return \DB::table('Messages')->where('chat_label', '=', $chat_label)->get();
    }

    public function selectAllNewMessages()
    {
        return \DB::table('Messages')->where('read', '=', '0')->get();
    }

    public  function selectLastMessage($chat_label)
    {
        return \DB::table('Messages')->select('chat_label','text','sender')->where('chat_label', '=', $chat_label)->orderBy('id','desc')->first();
    }

    public function textValidation($text, $start ,$len)
    {
            $text = mb_strimwidth($text, $start, $len , '...');

        return $text;
    }

    public function word_chunk($str, $len = 76, $end = "\n")
    {
        $pattern = '~.{1,' . $len . '}~u';

        $str = preg_replace($pattern, '$0' . $end, $str);

        return rtrim($str, $end);
    }

    public function createMessage($chat_id, $chat_label, $text = '', $first_name, $read)
    {
        $text = str_replace("\n", "<br>", $text);

        if (strlen($text) > 1000)
        {
            $arr_text = explode("\n", $this->word_chunk($text, 1000));

            $text = str_replace("<br>", "\n", $text);

            foreach ($arr_text as  $v)
            {
                Messages::create([
                    'chat_id'   => $chat_id,
                    'chat_label' => $chat_label,
                    'text'       => trim($v),
                    'sender'     => $first_name,
                    'read'       => $read,
                ]);
            }

            return true;
        }

        $text = str_replace("<br>", "\n", $text);

        return Messages::create([
                                'chat_id'   => $chat_id,
                                'chat_label' => $chat_label,
                                'text'       => $text,
                                'sender'     => $first_name,
                                'read'       => $read,
                                ]);
    }

    public function SaveReadMessages()
    {
        return \DB::table('Messages')->where('read', '=', 0)->where('chat_id', '=', $this->chat_id)->update(['read' => 1]);
    }


    public function send($telegramBotToken)
    {
        $this->createMessage($this->chat_id, $this->chat_label, $this->text, 'You', 1);

        $this->text = str_replace("<br>", "\n", $this->text);

        $telegramBotToken->sendMessage(['chat_id' => $this->chat_id, 'text' => $this->text]);
    }
}

