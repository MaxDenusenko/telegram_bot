<h2>Telegram bot</h2>
<h3>Before installation</h3>
<p>This Telegram bot is written using the Laravel 5.4. Read the <a href="https://laravel.com/docs/5.4/installation#server-requirements">system requirements</a> of this framework.</p>

<h3>Installation</h3>
<p>Upload all files to a working folder on your server</p>
<p>You should configure your web server's document / web root to be the  <code>public</code> directory. The <code>index.php</code> in this directory serves as the front controller for all HTTP requests entering your application.</p>
<p>At the root of the project there is an <code>.env.example</code> file, you need to rename it to <code>.env</code>, and fill it with a connection to the database</p>

<p>Run for execution command:</p>
<pre>composer update</pre>
<pre>php artisan key:generate</pre>
<p>Start the migration with the command:</p>
<pre>php artisan migrate</pre>
<h3>Setup</h3>
<p>Insert your bot token in the <code>.env</code> file</p>
<pre>BOT_TOKEN=token</pre> 
<p>If you want to cache the settings, use the command</p>
<pre>php artisan config:cache</pre>
<h3>Bot</h3>
<p>The bot receives user messages and writes them to active dialogs. An active dialog can only be one per user. When the active dialog is closed or deleted, the status changes to inactive all local messages to be assigned to it or in case the deletion is erased, a new active dialog is created and all unread messages are moved to it.</p>
