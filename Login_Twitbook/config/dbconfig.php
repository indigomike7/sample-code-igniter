<?php

define('DB_SERVER', 'sql100.byethost32.com');
define('DB_USERNAME', 'b32_11837326');
define('DB_PASSWORD', 'ju5tdoit');
define('DB_DATABASE', 'b32_11837326_studyratings');
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
$database = mysql_select_db(DB_DATABASE) or die(mysql_error());
?>
