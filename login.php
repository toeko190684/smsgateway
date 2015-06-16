<?php
include "connect.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PT. MORINAGA KINO INDONESIA - SMS GATEWAY</title>
	<link rel="stylesheet" type="text/css" href="themes/pepper-grinder/easyui.css">
	<link rel="stylesheet" type="text/css" href="themes/icon.css">
	<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="jquery.easyui.min.js"></script>
	<script>
		$(function(){
			$('#ok').click(function(){
				var username = $('#username').val();
				var password = $('#password').val();
				$.post('cek_login.php',{username : username,password : password},function(data){ 
					if(data=='oke'){
						window.location = 'aplikasi.php'
					}else{
						window.location = 'login.php'
					}
				});
			});
			
			$('#cancel').click(function(){
				$('#username').val("");
				$('#password').val("");
			});
		});
	</script>
</head>
<body>
    <div id="win" class="easyui-window" title="Login" style="width:300px;height:180px;">
		<form id='frmlogin' action='cek_login.php' style="padding:10px 20px 10px 40px;">
			<p>Username: <input type="text" id='username' required></p>
			<p>Password: <input type="password" id='password' required></p>
			<div style="padding:5px;text-align:center;">
				<a href="#" class="easyui-linkbutton" icon="icon-ok" id='ok'>Ok</a>
				<a href="#" class="easyui-linkbutton" icon="icon-cancel" id='cancel'>Cancel</a>
			</div>
		</form>
    </div>
</body>
</html>