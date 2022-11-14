<?php
	$nr_indeksu = '162436';
	$nrGrupy = '2';
	echo 'Zastosowanie metody include() <br />';
	echo 'Wojciech Kowalczyk '.$nr_indeksu.' grupa '.$nrGrupy.'<br /> <br />';
	echo 'Zastosowanie metody requie_once() <br />';
	echo '-> wyświetlenie treści pliku hello.php:  ';
	require_once 'hello.php';
	echo '<br /> <br />';
	echo 'Zastosowanie metody if() else() oraz else if() <br />';
	$a = 5;
	$b = 5;

	echo 'zmienna a='.$a.'<br />';
	echo 'zmienna b='.$b.'<br />';
	if ($a > $b)
		echo 'zmienna a jest większa od zmiennej b';
	else if ($a == $b)
		echo 'zmienna a = zmienna b';
	else
		echo 'zmienna b jest wieksza od zmiennej a';
	
	echo '<br /> <br />';
	echo 'Zastosowanie metody switch() <br />';
	
	$kolor = "czerwony";

	switch ($kolor) {
		case "czerwony":
			echo "Twój ulubiony kolor to czerwony";
		break;
		case "niebieski":
			echo "Twój ulubiony kolor to niebieski";
			break;
		case "zielony":
			echo "Twój ulubiony kolor to zielony";
			break;
		default:
			echo "Twoim ulubionym kolorem nie jest czerwony ani niebieski, ani zielony!";
	}
	echo '<br /> <br />';
	echo 'Zastosowanie pętli while <br />';
	$i = 1;
	while ($i <= 10) {
		echo $i++;  
	}
	
	echo '<br /> <br />';
	echo 'Zastosowanie pętli for <br />';
	for ($i = 10; $i >= 1; $i--) {
		echo $i;
	}
	
	echo '<br /> <br />';
	echo 'Zastosowanie zmiennej $_GET <br />';
	
?>
<html>
<body>

	<a href="test_get.php?subject=programowac&web=Internecie">Test $GET</a>
	<br />
	<br />
	<p>Zastosowanie zmiennej $_POST<p>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
		Name: <input type="text" name="fname">
		<input type="submit">
	</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $imie = $_POST['fname'];
  if (empty($imie)) {
    echo "Imie jest puste";
  } else {
    echo $imie;
  }
}
	echo '<br /> <br />';
	echo 'Zastosowanie zmiennej $_SESSION <br /> <br />';
	session_start();
	$_SESSION["color"] = "zielony";
	$_SESSION["animal"] = "pies";
	echo "Ulubiony kolor to " . $_SESSION["color"] . ".<br>";
	echo "Ulubione zwierze to " . $_SESSION["animal"] . ".";
?>


</body>
</html>

