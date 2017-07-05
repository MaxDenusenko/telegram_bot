<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Api;

class MainController extends Controller
{
    public $telegramBotToken;

    public function __construct()
    {
        $this->telegramBotToken = new Api('428165359:AAEYrJq5stUfPGzk1wdtY0fnEzQcRpANNlM');
    }
}
