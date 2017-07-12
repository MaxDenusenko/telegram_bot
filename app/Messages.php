<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Telegram\Bot\Api;

class Messages extends Model
{
    protected $table = 'Messages';

    protected $fillable = ['chat_id','chat_label','text', 'sender', 'read'];

    public function scopeWhereChatLabel($query, $chat_label)
    {
        return $query->where('chat_label', '=', $chat_label);
    }

    public function scopeWhereIdNull($query)
    {
        return $query->where('read', '=', '0');
    }

    public function deleteMessage($chat_label)
    {
        return $this->WhereChatLabel($chat_label)->where('read','=','1')->delete();
    }

    public function updateMessage_Status_Label($chat_label,$newLabel)
    {
        return $this->WhereChatLabel($chat_label)->WhereIdNull()->update(['chat_label' => $newLabel, 'read' => 1]);
    }

    public  function selectNewMessages($chat_id)
    {
        return $this->where('chat_id','=', $chat_id)->WhereIdNull()->get();
    }

    public function updateStatusMessage($chat_label)
    {
        return $this->WhereChatLabel($chat_label)->update(['read' => '1']);
    }

    public function selectMessage($chat_label)
    {
        return $this->WhereChatLabel($chat_label)->get();
    }

    public function selectAllNewMessages()
    {
        return $this->WhereIdNull()->get();
    }

    public  function selectLastMessage($chat_label)
    {
        return $this->select('chat_label','text','sender')->WhereChatLabel($chat_label)->orderBy('id','desc')->first();
    }

    public function textValidation($text, $start ,$len)
    {
        $text = mb_strimwidth($text, $start, $len , '...');

        return $text;
    }

    public function wordChunk($str, $len = 76, $end = "\n")
    {
        $pattern = '~.{1,' . $len . '}~u';

        $str = preg_replace($pattern, '$0' . $end, $str);

        return rtrim($str, $end);
    }

    public function createMessage($chat_id, $chat_label, $text, $first_name, $read)
    {
        $text = str_replace("\n", "<br>", $text);

        if (strlen($text) > 1000) {
            $arr_text = explode("\n", $this->wordChunk($text, 1000));

            foreach ($arr_text as  $v) {
                $this->create([
                    'chat_id'    => $chat_id,
                    'chat_label' => $chat_label,
                    'text'       => trim($v),
                    'sender'     => $first_name,
                    'read'       => $read,
                ]);
            }
            return true;
        }
        
        return $this->create([
                                'chat_id'    => $chat_id,
                                'chat_label' => $chat_label,
                                'text'       => $text,
                                'sender'     => $first_name,
                                'read'       => $read,
                                ]);
    }

    public function saveReadMessages()
    {
        return $this->WhereIdNull()->where('chat_id', '=', $this->chat_id)->update(['read' => 1]);
    }


    public function send($telegramBotToken, $chat_id, $chat_label, $text)
    {
        $this->createMessage($chat_id, $chat_label, $text, 'You', 1);

        $text = str_replace("<br>", "\n", $text);

        $telegramBotToken->sendMessage(['chat_id' => $chat_id, 'text' => $text]);
    }
}

