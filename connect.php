<?php
$host = "localhost";
$username = "root";
$password = "m0r1n@g@";
$database = "smsgateway";

mysql_connect($host,$username,$password) or die("tidak terkoneksi keserver mysql");
mysql_select_db($database) or die ("tidak terkoneksi ke datatabase smsgateway");

?>