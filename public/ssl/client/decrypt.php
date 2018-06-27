<?php

ini_set('date.timezone','Asia/Shanghai');

require_once __DIR__."/../lib/AlpacaSSL.php";

$result = AlpacaSSL::model()->decrypt($_POST);

var_dump($result);
die;

