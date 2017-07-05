<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersChat extends Model
{
    protected $table = 'UsersChat';

    protected $fillable = ['user_id','first_name','last_name','language_code'];

    public function getUser($user_id)
    {
        return \DB::table('UsersChat')->where('user_id', '=', $user_id)->get();
    }

    public function createUser($user_id, $first_name, $last_name = '', $language_code = '')
    {
        return UsersChat::create([
                                'user_id'          => $user_id,
                                'first_name'       => $first_name,
                                'last_name'        => $last_name,
                                'language_code'    => $language_code
                                ]);
    }

    public function selectUsers()
    {
        return \DB::table('UsersChat')->select('id','user_id', 'first_name', 'last_name', 'language_code')->get();
    }
}

