<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Api;

class MainController extends Controller
{
    public $telegramBotToken;

    public function __construct()
    {
        $this->telegramBotToken = new Api(config('telegram.bot_token'));
    }
}
