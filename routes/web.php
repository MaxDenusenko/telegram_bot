<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function ()
{
    if ( !Auth::check() )
    {
        return redirect('login');
    }
    else
    {
        return redirect('home');
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/bot', 'IndexController@bot')->name('botQ');

Route::get('/chats/{id}', 'IndexController@chats')->name('chatsQ');

Route::get('/users', 'IndexController@users')->name('chatsQ');

Route::get('/MessagesQ/{label}', 'IndexController@messages')->name('MessagesQ');

Route::get('/sendMessage', array('uses' => 'IndexController@sendMessage'));

Route::get('/retrieveChatMessages', array('uses' => 'IndexController@retrieveChatMessages'));

Route::get('/closeChat', array('uses' => 'IndexController@closeChat'));

Route::get('/deleteChat', array('uses' => 'IndexController@deleteChat'));
