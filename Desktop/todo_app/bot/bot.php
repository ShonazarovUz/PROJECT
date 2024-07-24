<?php
require "src/Bot.php";
require 'src/User.php';

$bot = new Bot();
$user = new User();
$update = json_decode(file_get_contents('php://input'));

if (isset($update->message)) {
    $message = $update->message;
    $chatId = $message->chat->id;
    $text = $message->text;

    if ($text === '/start') {
        $bot->StartCommand($chatId);
        return;
    }

    if ($text === "/add") {
        $user->save_user($chatId, '/add');
        $user->setAction($chatId, '/add');
        $bot->AddCommand($chatId);
    }

}
?>