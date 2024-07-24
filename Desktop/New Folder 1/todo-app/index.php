<?php

require_once "vendor/autoload.php";
require 'functions.php';

date_default_timezone_set('Asia/Tashkent');

$update = json_decode(file_get_contents('php://input'));
$task = new Task();

if (isset($update)) {
    if (isset($update->update_id)) {
        require 'bot/bot.php';
        return;
    }

    $path = parse_url($_SERVER['REQUEST_URI'])['path'];

    if ($path === '/add') {
        $task->add($update->text, $update->userId);
    }

    if (isset($_GET['delete'])) {
        $task->delete($_GET['delete']);
    }
    
    if (isset($_GET['complete'])) {
        $task->complete($_GET['complete']);
    }

    if (isset($_GET['uncomplete'])) {
        $task-> uncomplete($_GET['uncomplete']);
    }
}

if ($_SERVER['REQUEST_URI'] === '/tasks') {
    echo json_encode($task->getAll());
    return;
}

require 'view/home.php';
