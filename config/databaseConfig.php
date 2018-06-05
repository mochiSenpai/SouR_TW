<?php

$conn_error = 'Unable to connect to database...';
$mysql_user = 'sour_db';
$mysql_pass = 'aqjFKSuquY9K9jrv';
$mysql_db = 'twsourdb';
$mysql_host = 'db4free.net:3306/';


$dbconn = new mysqli($mysql_host, $mysql_user, $mysql_pass, $mysql_db) or die($conn_error);

?>