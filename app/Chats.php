<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    protected $table = 'Chats';

    protected $fillable = ['chat_id','chat_label','type','status'];

    public function deleteChat($chat_label)
    {
        return \DB::table('Chats')->where('chat_label', '=', $chat_label)->delete();
    }

    public function updateChatStatus_NoActive($chat_label)
    {
        return \DB::table('Chats')->where('chat_label', '=', $chat_label)->update(['status' => 'noActive']);
    }

    public function selectActiveChat($chat_label)
    {
        return \DB::table('Chats')->where('chat_label','=', $chat_label)->where('status', '=', 'active')->get();
    }

    public function selectChats($chat_id)
    {
        return \DB::table('Chats')->where('chat_id', '=', $chat_id)->get();
    }

    public function createChat($chat_id, $chat_label, $type, $status)
    {
        return Chats::create([
                            'chat_id'         => $chat_id,
                            'chat_label'    => $chat_label,
                            'type'          => $type,
                            'status'        => $status,
                            ]);
    }

    public function selectChatLabel($status, $user_id)
    {
        return \DB::table('Chats')->select('chat_label')->where('status', '=', $status)->where('chat_id', '=', $user_id)->get();
    }
}

