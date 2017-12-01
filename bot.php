<?php

require_once './vendor/autoload.php';
require_once "IdBot.php";

$config = [];
$bot = new IdBot('Identy Bot', 'Simple bot showing id of users or groups', 'prowebcraft', 'prowebcraft@gmail.com', []);

//Run in webhook mode
$bot->webhook();

//Run in daemon mode
//$bot->start();
