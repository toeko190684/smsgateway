<?php
$host ="localhost";
$username ="root";
$password = "";
$database3 = "it";

@mysql_connect($host,$username,$password) or die ("couldn't connect to IT database");
@mysql_select_db($database3) or die ("couldn't connect to smysql database it");

//koneksi ke sql server
$odbc= @odbc_connect("2NDSALES","sa","") or die ("could not connect to 2ndsales database");

$odbc2 = @odbc_connect("kinosentrajit","sa","") or die("could not connct to kinosentrajit database");

$odbc3 = @odbc_connect("kinosentraacc","sa","") or die("could not connct to kinosentrajit database");



// koneksi ke smsgateway postgreesql
$conn_string = "host=192.168.21.3 port=5432 dbname=smsg user=smsg password=1q2w3e4r5t6y";
$connection = @pg_pconnect($conn_string);
if (!$connection) {
print("Connection Failed.");
exit;
}
?>
