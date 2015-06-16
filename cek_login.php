<?php
session_start();
include "connect.php";
$password = md5($_POST[password]);
$sql = mysql_query("select * from user where Name ='$_POST[username]' and sandi='$password'");
$r = mysql_fetch_array($sql);
$cek = mysql_num_rows($sql);
if($cek>0){
    $_SESSION[username] = $r[Name];
	$_SESSION[password] = $r[sandi];
	echo "oke";
}
?>