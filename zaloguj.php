<?php

function FormularzLogowania()
	{
		include('cfg.php');
		if($_SESSION['loginFailed'] != 0) {
		$result = 
		'
			<center><h2 style="margin-top:100px">Zaloguj się</h2>
			<form method="post" name="logowanie" action="'.$_SERVER['REQUEST_URI'].'">
				<label>Login: </label>
				<input type="login" name="username"/><br><br>
				<label>Hasło: </label>
				<input type="password" id="form3_2" name="password"/><br><br>
				<button type="submit">Zaloguj się</button>
			</form>
			</center>			
		';
	return $result;
		}
	}
echo FormularzLogowania(); 

if($_SESSION['loginFailed'] == 0) {
	echo "<center><div style='margin-top:100px'><h1>Wybierz stronę:</h1><br>
			<a href='admin/admin.php'><h2 style='color: red'>Panel administracyjny CMS</h2></a>
			<a href='categories_management.php'><h2 style='color: red'>Sklep</h2></a>
			<a href='index.php'><h2 style='color: red'>Strona główna</h2></a></div></center></div></center>";
	
    
	} else
	echo '<center><a href="index.php"><h2 style="color: red">Strona główna</h2></a></div></center></div>';

?>