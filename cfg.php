<?php
	$host = 'localhost';
	$user = 'root'
	$pass = '';
	$database = 'moja_strona'
	
	$link = mysqli_connect($host, $user, $pass);
	if	(!$link) 
	{
		echo '<b>Połączenie zostało przerwane!<b/>';
	}
	if	(!mysqli_select_db($database)) 
	{
		echo '<b>Nie wybrano bazy!<b/>';
	}

?>