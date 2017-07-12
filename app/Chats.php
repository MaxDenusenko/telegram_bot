<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    protected $table = 'Chats';

    protected $fillable = ['chat_id','chat_label','type','status'];

    public function scopeWhereChatLabel($query, $chat_label)
    {
        return $query->where('chat_label', '=', $chat_label);
    }

    public function deleteChat($chat_label)
    {
        return $this->WhereChatLabel($chat_label)->delete();
    }

    public function updateChatStatus_NoActive($chat_label)
    {
        return $this->WhereChatLabel($chat_label)->update(['status' => 'noActive']);
    }

    public function selectActiveChat($chat_label)
    {
        return $this->WhereChatLabel($chat_label)->where('status', '=', 'active')->get();
    }

    public function selectChats($chat_id)
    {
        return $this->where('chat_id', '=', $chat_id)->get();
    }

    public function createChat($chat_id, $chat_label, $type, $status)
    {
        return $this->create([
                            'chat_id'       => $chat_id,
                            'chat_label'    => $chat_label,
                            'type'          => $type,
                            'status'        => $status,
                            ]);
    }

    public function selectChatLabel($status, $user_id)
    {
        return $this->select('chat_label')->where('status', '=', $status)->where('chat_id', '=', $user_id)->get();
    }
}

