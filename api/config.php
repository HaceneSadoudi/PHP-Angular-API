<?php

$hostname = "localhost";
$database = "stock";
$db_user = "root";
$db_pass = "";

$db = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8", $db_user, $db_pass);

// set db attributes
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

define('APP_NAME', 'PHP REST API');

