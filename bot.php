<?php

require_once './vendor/autoload.php';
require_once "IdBot.php";

$config = [];
$bot = new IdBot('Identy Bot', 'Simple bot showing id of users or groups', 'prowebcraft', 'prowebcraft@gmail.com', []);

if ($bot->isConsoleMode()) {
    //Run in daemon mode
    if (isset($argv[1]) && $argv[1] == 'webhook') {
        $bot->webhook();
    } else {
        $bot->start();
    }
} else {
    //Run in webhook mode
    $bot->webhook();
}
