<?php
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
	if($_GET['idp'] == '') $strona = 'html/glowna.html';
	if($_GET['idp'] == 'trening') $strona = 'html/trening.html';
	if($_GET['idp'] == 'kontakt') $strona = 'html/kontakt.html';
	if($_GET['idp'] == 'relacje') $strona = 'html/relacje.html';
	if($_GET['idp'] == 'galeria') $strona = 'html/galeria.html';
	if($_GET['idp'] == 'fb') $strona = 'html/fb.html';
	if($_GET['idp'] == 'filmy') $strona = 'html/filmy.html';
?>


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
			<div class="option"><a href="index.php?idp=kontakt">Kontakt</a></div>
			<div class="option"><a href="index.php?idp=relacje">Relacje z wyścigów</a></div>
			<div class="option"><a href="index.php?idp=galeria">Galeria</a></div>
			<div class="option"><a href="index.php?idp=fb">Facebook</a></div>
			<div class="option"><a href="index.php?idp=filmy">Filmy</a></div>
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
				if (file_exists($strona)){
					include($strona);
				}
				else {
					throw new ErrorException($site . "Plik nie istnieje!");
				}
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

