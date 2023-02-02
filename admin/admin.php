<?php

include('../cfg.php');
echo "<center><h1>Panel administracyjny CMS<h1>
		
	</center>
	<br><br>
	<center><a href='../categories_management.php'><h2 style='color: red'>Sklep</h2></a>
	<a href='../index.php'><h2 style='color: red'>Strona główna</h2></a><br><br>
	</center>
	";

function pokazWszystkiePodstrony() {
    include('../cfg.php');
    $query = " SELECT * FROM page_list ";
    $result = mysqli_query($link, $query);
    while( $row = mysqli_fetch_array($result) ) {
        $id = $row['id'];
        $page_content = htmlspecialchars($row['page_content']);
        $page_title = $row['page_title'];

        $table ="
        <center>
		<table style='background-color: white'>
            <tr>
                <td style='border: 2px solid black;'><h2>ID strony</h2></td>
                <td style='border: 2px solid black;'><h2>Tytuł podstrony</h2></td>
                <td style='border: 2px solid black;'><h2>Zawartość strony (KOD HTML)</h2></td>
            </tr>
            <tr>
                <td style='border: 2px solid black;'><h3>".$id."</h3></td>
                <td style='border: 2px solid black;'><h3>".$page_title."</h3></td>
                <td style='border: 2px solid black;'><h4>".$page_content."</h4></td>        
            </tr>
        </table>        
		<br>
        <form method='post'>
            <input type='hidden' name='idP' value='" . $id . "'/>
            <input type='hidden' name='titleP' value='" . $page_title . "'/>
            <input type='hidden' name='contentP' value='" . $page_content . "'/> <br>
            <button type='submit' name='edit' class='btn btn-warning'>Edytuj podstronę</button>

        </form>
        <form method='post'>
            <input type='hidden' name='idToDelete' value='" . $id . "'/>
            <button type='submit' name='delete' class='btn btn-danger'>Skasuj podstronę</button>
        </form><br>
       <br>
	   </center>";
	  
        echo $table;
    }
}

function FormularzLogowania()
	{
		include('../cfg.php');
		if($_SESSION['loginFailed'] != 0) {
		$result = 
		'
			<center><h2>Zaloguj się</h2>
			<form method="post" name="logowanie" action="'.$_SERVER['REQUEST_URI'].'">
				<label>Login: </label>
				<input type="login" name="username"/><br><br>
				<label>Hasło: </label>
				<input type="password" id="form3_2" name="password"/><br><br>
				<button type="submit">Zaloguj się</button>
			</form></center>			
		';
	return $result;
		}
	}

function UpdateForm() {
    include('../cfg.php');

    if(empty($_POST['idP'])) {
        return "";
    }

    $id = $_POST['idP'];
    $title = $_POST['titleP'];
    $content = htmlspecialchars($_POST['contentP']);


    $update_form = 
    "
        <center>
		<h1>Edytuj strone ".$title." #".$id."</h1>
        <form method='post'>
			<table style='background-color: white'>
				<tr>
					<td style='border: 2px solid black;'><h2>ID strony</h2></td>
					<td style='border: 2px solid black;'><h2>Tytuł podstrony</h2></td>
					<td style='border: 2px solid black;'><h2>Zawartość strony (KOD HTML)</h2></td>
				</tr>
				<tr>
					<td style='border: 2px solid black;'><h3>".$id."</h3></td>
					<td style='border: 2px solid black;'><h3>".$title."</h3></td>
					<td><textarea style='height: 400px; width: 400px' name='update_content'>".$content." </textarea></td>
				</tr>
			</table>       
            <br>
            <button type='submit'>Zapisz</button>
			<button formaction='admin.php'>Wstecz</button>
            </form>
			</center>
        
        ";
    return $update_form;
	
	
}

function queryUpdate() {
    include('../cfg.php');

    $id = $_POST['update_id'];
    $title = $_POST['update_title'];
    $content = $_POST['update_content'];

    $query = "UPDATE `page_list` SET `page_title`='".$title."' , `page_content`=' ".htmlspecialchars($content)." ' WHERE `id`=".$id." LIMIT 1";
    $result = mysqli_query($link, $query);

    return $result;

}



function queryDelete() {
    include('../cfg.php');
    $id = $_POST['idToDelete'];
    $query = "DELETE FROM `page_list` WHERE id=$id LIMIT 1";
    $result = mysqli_query($link, $query);
    return $result;
}
function open_window($url){
   echo '<script>window.open ("'.$url.'", "mywindow","status=0,toolbar=0")</script>';
}


error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING); 


function insertForm() {
    
    include('../cfg.php');

    $insertForm =
        '
			<center>
			<h2>Dodaj kolejną stronę</h2>
            <form method="post">
				<label>Tytuł podstrony</label>
				<input type="text" name="insertTitle"/><br><br>
				<label>Zawartość (Kod HTML)</label><br><br>
				<textarea style="height: 400px; width: 700px" name="insertContent"></textarea>
				<br><br>
                <button type="submit" class="btn btn-success" name="insert">Zapisz</button>
				<button formaction="../zaloguj.php">Wstecz</button>
				
                </form><br>
				</center>
                   
        ';

    return $insertForm;
}

function queryInsert() {

    include('../cfg.php');
    
    $title = $_POST['insertTitle'];
    $content = $_POST['insertContent'];
    $query = "INSERT INTO `page_list` (`page_title`, `page_content`) values('$title', '$content')";
    $result = mysqli_query($link, $query);

    return $result;

}


echo formularzLogowania();



if($_SESSION['loginFailed'] == 0) {

    echo UpdateForm();
	echo insertForm();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if(isset($_POST['update_id'])) {
            echo queryUpdate();
            exit;
        }

        if(isset($_POST['idToDelete'])) {
            echo queryDelete();
            exit;
        }

        if(isset($_POST['insertTitle'])) {
            echo queryInsert();
            exit;
        }
    }

    echo FormularzLogowania();
	pokazWszystkiePodstrony();


}


?>