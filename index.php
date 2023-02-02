<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Moje hobby to kolarstwo</title>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<script src="js/timedate.js" type="text/javascript"></script>
	<script src="js/kolorujtlo.js" type="text/javascript"></script>
	<script src="js/jquery-3.6.1.js"></script>
</head>
<body onload="startclock()">
	
	<div id="container">
		<div id="logo">
			Cyklomaniak - Wojciech Kowalczyk
		</div>
		<div id="zegarek"></div>
		<div id="data"></div>
		
		<div id="menu">
			<div class="option"><a href="index.php?idp=">Strona główna</a></div>
			<div class="option"><a href="index.php?idp=trening">Trening</a></div>
			<div class="option"><a href="contact.php">Kontakt</a></div>
			<div class="option"><a href="index.php?idp=relacje">Relacje z wyścigów</a></div>
			<div class="option"><a href="index.php?idp=galeria">Galeria</a></div>
			<div class="option"><a href="index.php?idp=javascript">JavaScript</a></div>
			<div class="option"><a href="index.php?idp=filmy">Filmy</a></div>
			<div class="option"><a href="zaloguj.php">Zaloguj się</a></div>
			<div style="clear:both;"></div>
		</div> 
		
		<div id="topbar">
			<div id="topbarL">
				<img src="img/logo.png" />
			</div>
			<div id="topbarR">
				
				<span class="bigtitle">Moje motto</span> <br><br>
				
				<h2>"Sukces to suma wysiłku powtarzanego z dnia na dzień..."</h2>
				
				<div style="height: 15px;"></div>
				
			</div>
			<div style="clear:both;"></div>
		</div>
			<?php
				error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
				include('cfg.php');
				include('showpage.php');
				if($_GET['idp'] == '') $strona = 1;
				if($_GET['idp'] == 'trening') $strona = 2;
				if($_GET['idp'] == 'kontakt') $strona = 4;
				if($_GET['idp'] == 'relacje') $strona = 3;
				if($_GET['idp'] == 'galeria') $strona = 5;
				if($_GET['idp'] == 'javascript') $strona = 7;
				if($_GET['idp'] == 'filmy') $strona = 6;
				echo PokazPodstrone($strona);
			?>
		<div id="footer">
		<div class="dottedline"></div>
		<?php
			$nr_indeksu = '162436';
			$nrGrupy = '2';
			echo 'Autor: Wojciech Kowalczyk '.$nr_indeksu.' grupa '.$nrGrupy.'<br /><br />';
		?>
		</div>
	</div>
</body>
</html>

