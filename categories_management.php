<?php
session_start();

 error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    

function list_products($category_id) {
    include ("cfg.php");

    $query="SELECT * FROM product WHERE kategoria = $category_id";
    $result_set=mysqli_query($link, $query);

    while($row = mysqli_fetch_array($result_set)) {
        $id = $row['id'];
        $tytul = $row['tytul'];
        $opis = $row['opis'];
        $data_utworzenia = $row['data_utworzenia'];
        $data_modyfikacji = $row['data_modyfikacji'];
        $data_wygasniecia = $row['data_wygasniecia'];
        $cena_netto = $row['cena_netto'];
        $vat = $row['podatek_vat'];
        $ilosc = $row['dostepna_ilosc'];
        $status_dostepnosci = $row['status_dostepnosci'];
        $kategoria = $row['kategoria'];
        $gabaryt = $row['gabaryt'];
        $zdjecie = base64_encode($row['zdjecie']);
        $buyable = true;

        if(date("Y-m-d", strtotime($data_wygasniecia)) < date("Y-m-d") || $ilosc <= 0 || $status_dostepnosci == 0) {
            $buyable = false;
        }

        $add_to_cart = "";

        $color = "dark";
        if (!$buyable) {
            $color = "red";
            $add_to_cart = "PRODUCT UNAVAILABLE";
        } else {
            $add_to_cart = "
                        <form method='post'>
                        <input type='hidden' name='add_to_cart_id' value='".$id."'/>
                        <input type='hidden' name='add_to_cart_quantity_left' value='".$ilosc."'/>
                        <input type='submit' name='delete' value='Dodaj do koszyka'/>
                        </form>";
        }

        $page_result  = "
        
		<div >
        <div>
            <table style='background-color: white'>
                <thead>
                    <th style='border: solid 2px'><span>ID</span></th>
                    <th style='border: solid 2px'><span>tytul</span></th>
                    <th style='border: solid 2px'><span>opis</span></th>
                    <th style='border: solid 2px'><span>data utworzenia</span></th>
                    <th style='border: solid 2px'><span>data modyfikacji</span></th>
                    <th style='border: solid 2px'><span>data wygasniecia</span></th>
                    <th style='border: solid 2px'><span>cena netto</span></th>
                    <th style='border: solid 2px'><span>podatek vat</span></th>
                    <th style='border: solid 2px'><span>dostepna ilosc</span></th>
                    <th style='border: solid 2px'><span>status dostepnosci</span></th>
                    <th style='border: solid 2px'><span>kategoria</span></th>
                    <th style='border: solid 2px'><span>gabaryt</span></th>
                    <th style='border: solid 2px'><span>zdjecie</span></th>
                    <th style='border: solid 2px'><span>akcje</span></th>
                </thead>
                <tbody>
                    <tr> 
                    <td style='border: solid 2px'>".$id."</td>
                    <td style='border: solid 2px'>$tytul</td>    
                    <td style='border: solid 2px'>$opis</td>    
                    <td style='border: solid 2px'>$data_utworzenia</td>
                    <td style='border: solid 2px'>$data_modyfikacji</td>
                    <td style='border: solid 2px'>$data_wygasniecia</td> 
                    <td style='border: solid 2px'>$cena_netto</td>
                    <td style='border: solid 2px'>$vat</td>
                    <td style='border: solid 2px'>$ilosc</td>
                    <td style='border: solid 2px'>$status_dostepnosci</td>
                    <td style='border: solid 2px'>$kategoria</td>
                    <td style='border: solid 2px'>$gabaryt</td>
                    <td style='border: solid 2px'><img style='width: 75px; height: 75px' src='data:image/jpeg;base64, $zdjecie'/></td>
                    <td style='border: solid 2px'><form method='post'>
                        <input type='hidden' name='product_update_id' value='".$id."'/>
                        <input type='submit' name='update_product' value='Edytuj'/>
                    </form>
                    <form method='post'>
                        <input type='hidden' name='product_to_delete_id' value='".$id."'/>
                        <input type='submit' name='delete' value='Usuń'/>
                    </form>
                    $add_to_cart
                    </td>
                    </tr>       
                </tbody>
            </table>
            
        </div>
        
        </div>
        ";
        echo $page_result;

    }
}

function list_categories() {
    include "cfg.php";

    $query="SELECT * FROM category WHERE parent = 0";
    $result=mysqli_query($link, $query);

    while($row = mysqli_fetch_array($result)) {
        $id=$row['id'];
        $parent = $row['parent'];
        $name=$row['name'];

        $child_query = "SELECT * FROM category WHERE parent = $id";
        $child_categories = mysqli_query($link, $child_query);


        $page_result  = "
        <div >
        <div>
            <table style='background-color: white'>
                <thead>
                    <th style='border: solid 2px'><span>ID</span></th>
                    <th style='border: solid 2px'><span>name</span></th>
                    <th style='border: solid 2px'><span>actions</span></th>
                </thead>
                <tbody>
                    <tr> 
                    <td style='border: solid 2px'>".$id."</td>
                    <td style='border: solid 2px'>".$name."</td>
                    <td style='border: solid 2px'><form method='post'>
                        <input type='hidden' name='category_id' value='".$id."'/>
                        <input type='hidden' name='category_parent' value='".$parent."'/>
                        <input type='hidden' name='category_name' value='".$name."'/>
                        <input type='submit' name='edit' value='Edytuj'/>
                    </form>
                    <form method='post'>
                        <input type='hidden' name='category_to_delete_id' value='".$id."'/>
                        <input type='submit' name='delete' value='Usuń'/>
                    </form></td>
                    </tr>       
                </tbody>
            </table>
            
        </div>
        
        </div>
        <br>
        ";
        echo $page_result;
        while ($child_row = mysqli_fetch_array($child_categories)) {

            $child_id = $child_row['id'];
            $child_parent = $child_row['parent'];
            $child_name = $child_row['name'];

            $children_result = "
            <div >
            <div >
                <table style='background-color: white'>
                    <thead>
                        <th style='border: solid 2px'><span >ID</span></th>
                        <th style='border: solid 2px'><span >parent</span></th>
                        <th style='border: solid 2px'><span >name</span></th>
                        <th style='border: solid 2px'><span>actions</span></th>
                    </thead>
                    <tbody>
                        <tr> 
                        <td style='border: solid 2px'>".$child_id."</td> 
                        <td style='border: solid 2px'>".$child_parent." ".$name."</td>
                        <td style='border: solid 2px'>".$child_name."</td>
                        <td style='border: solid 2px'><form method='post'>
                            <input type='hidden' name='category_id' value='".$child_id."'/>
                            <input type='hidden' name='category_parent' value='".$child_parent."'/>
                            <input type='hidden' name='category_name' value='".$child_name."'/>
                            <input type='submit' name='edit' value='Edytuj'/>
                        </form>
                        <form method='post'>
                            <input type='hidden' name='category_to_delete_id' value='".$child_id."'/>
                            <input type='submit' name='delete' value='Usuń'/>
                        </form>
                        <form method='post'>
                            <input type='hidden' name='product_category' value='".$child_id."'/>
                            <input type='submit' name='new_product' value='Dodaj produkt'/>
                        </form>
                        </td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
           
            </div>
            <br>
        ";

        echo $children_result;
        list_products($child_id);
        echo "<br>";
        }
        echo "<br><hr style='height: 2px; background: red'><br>";

    }
}

function add_category_form() {
    $new_page_form = "
        <div>
        <div>
            <h1>Dodaj kategorie</h1>
            <form method='post'>
            <table style='width: 100%; background-color: white'>
                <thead>
                    <th style='width: 50%; border: solid 2px'><span>parent</span></th>
                    <th  style='width: 50%; border: solid 2px'><span>name</span></th>
                </thead>
                <tbody>
                    <tr>
                    <td style='border: solid 2px'>
                    <input style='width: 99%' type='text' name='new_category_parent' placeholder='Nazwa kategorii nadrzędnej'/>
                    </td>
                    <td style='border: solid 2px'>
                    <input style='width: 99%' type='text' name='new_category_name' placeholder='Nazwa katagorii podrzędnej'/>
                    </td>
                    </tr>       
                </tbody>
            </table><br>
            <button type='submit'>Zapisz</button>
            </form>
        </div>
        </div>
        ";
    return $new_page_form;
}

function edit_category_form() {
    include('cfg.php');

    $id = $_POST['category_id'];
    $parent = $_POST['category_parent'];
    $name = $_POST['category_name'];


    $edit_form = "
        <div>
        <div>
            <h1>Edytuj kategorie ".$name." #".$id."</h1>
            <form method='post'>
            <table style='width:100px; height: 100px; background-color: white'>
                <thead>
                    <th style='border: solid 2px'><span>ID</span></th>
                    <th style='border: solid 2px'><span>parent</span></th>
                    <th style='border: solid 2px'><span>name</span></th>
                </thead>
                <tbody>
                <tr>
                     <td style='border: solid 2px'><input type='text' readonly value='".$id."' name='edit_id'/></td>
                     <td style='border: solid 2px'><input type='text' name='edit_parent' value='".$parent."'/></td>
                     <td style='border: solid 2px'><input type='text' name='edit_name' value='".$name."'></td> 
                 </tr>       
                </tbody>
            </table><br>
            <button type='submit'>Zapisz</button>
            </form>
        </div>
        </div>
        <br><br>
        ";
    echo $edit_form;
}

function new_product_form() {
    $category = $_POST['product_category'];

    $new_product_form = "
        <div>
        <div>
            <h1>Dodaj nowy produkt do kategorii # $category</h1>
            <form method='post' enctype='multipart/form-data'>
            <table style='width: 100%; background-color: white'>
            <thead>
                    <th style='border: solid 2px'><span>tytul</span></th>
                    <th style='border: solid 2px'><span>opis</span></th>
                    <th style='border: solid 2px'><span>data utworzenia</span></th>
                    <th style='border: solid 2px'><span>data wygasniecia</span></th>
                    <th style='border: solid 2px'><span>cena netto</span></th>
                    <th style='border: solid 2px'><span>podatek vat</span></th>
                    <th style='border: solid 2px'><span>ilosc</span></th>
                    <th style='border: solid 2px'><span>status dostepnosci</span></th>
                    <th style='border: solid 2px'><span>kategoria</span></th>
                    <th style='border: solid 2px'><span>gabaryt (1-5)</span></th>
                    <th style='border: solid 2px'><span>zdjecie</span></th>
                </thead>
                <tbody>
                    <tr>
                    <td style='border: solid 2px'>
                    <input style='width: 95%' type='text' name='new_product_tytul' placeholder='Tytul'/>
                    </td>
					<td style='border: solid 2px'>
                    <input style='width: 95%' type='text' name='new_product_opis' placeholder='Opis'/>
                    </td>
                    <td style='border: solid 2px'>
                    <input style='width: 95%' type='date' name='new_product_date'/>
                    </td>
                    <td style='border: solid 2px'>
                    <input style='width: 95%' type='date' name='new_product_expiration'/>
                    </td>
                    <td style='border: solid 2px'>
                    <input style='width: 95%' type='number' name='new_product_netto' step='0.01'/>
                    </td>
                    <td style='border: solid 2px'>
                    <input style='width: 95%' type='number' name='new_product_vat'/>
                    </td>
                    <td style='border: solid 2px'>
                    <input style='width: 95%' type='number' name='new_product_ilosc'/>
                    </td>
                    <td style='border: solid 2px'>
                    <input style='width: 95%' type='text' name='new_product_status' value=''/>
                    </td>
                    <td style='border: solid 2px'>
                    <input style='width: 95%' type='text' name='new_product_category' value='$category' readonly/>
                    </td>
                    <td style='border: solid 2px'>
                    <input style='width: 95%' type='number' name='new_product_gabaryt'/>
                    </td>
                    <td style='border: solid 2px'>
                    <input style='width: 95%' type='file' name='newproductphoto'/>
                    </td>
                    
                    </tr> 
                </tbody>
                </table><br>
            <button type='submit'>Zapisz</button>
            </form>
        </div>
        </div>
        <br>
        ";
    return $new_product_form;
}

function edit_product_form() {
    include("cfg.php");
    $product_id = $_POST['product_update_id'];


    $query="SELECT * FROM product WHERE id = $product_id LIMIT 1";
    $result_set=mysqli_query($link, $query);

    while($row = mysqli_fetch_array($result_set)) {
        $id = $row['id'];
        $tytul = $row['tytul'];
        $opis = $row['opis'];
        $data_utworzenia = $row['data_utworzenia'];
        $data_wygasniecia = $row['data_wygasniecia'];
        $cena_netto = $row['cena_netto'];
        $vat = $row['podatek_vat'];
        $ilosc = $row['dostepna_ilosc'];
        $status_dostepnosci = $row['status_dostepnosci'];
        $kategoria = $row['kategoria'];
        $gabaryt = $row['gabaryt'];
        $zdjecie = base64_encode($row['zdjecie']);

        $edit_product_form = "
        <div>
        <div>
            <h1>Edytuj produkt $tytul</h1>
            <form method='post' enctype='multipart/form-data'>
            <table style='width: 100%; background-color: white'>
            <thead>
                    <th style='border: solid 2px'><span>id</span></th>
                    <th style='border: solid 2px'><span>tytul</span></th>
                    <th style='border: solid 2px'><span>opis</span></th>
                    <th style='border: solid 2px'><span>data utworzenia</span></th>
                    <th style='border: solid 2px'><span>data wygasniecia</span></th>
                    <th style='border: solid 2px'><span>cena netto</span></th>
                    <th style='border: solid 2px'><span>podatek vat</span></th>
                    <th style='border: solid 2px'><span>dostepna ilosc</span></th>
                    <th style='border: solid 2px'><span>status dostepnosci</span></th>
                    <th style='border: solid 2px'><span>kategoria</span></th>
                    <th style='border: solid 2px'><span>gabaryt</span></th>
                    <th style='border: solid 2px'><span>zdjecie</span></th>
                </thead>
                <tbody>
                    <tr>
                    <td style='border: solid 2px'>
                    <input style='width: 95%' type='text' name='update_product_id' value='$id' readonly/>
                    </td>
					<td style='border: solid 2px'>
                    <input style='width: 95%' type='text' name='update_product_tytul' value='$tytul'/>
                    </td>
                    <td style='border: solid 2px'>
                    <input style='width: 300px; height: 100px' type='text' name='update_product_opis' value='$opis'/>
                    </td>
                    <td style='border: solid 2px'>
                    <input style='width: 95%' type='date' name='update_product_date' value='$data_utworzenia'/>
                    </td>
                    <td style='border: solid 2px'>
                    <input style='width: 95%' type='date' name='update_product_expiration' value='$data_wygasniecia'/>
                    </td>
                    <td style='border: solid 2px'>
                    <input style='width: 95%' type='number' name='update_product_netto' value='$cena_netto' step='0.01'/>
                    </td>
                    <td style='border: solid 2px'>
                    <input style='width: 95%' type='number' name='update_product_vat' value='$vat'/>
                    </td>
                    <td style='border: solid 2px'>
                    <input style='width: 95%' type='number' name='update_product_ilosc' value='$ilosc'/>
                    </td>
                    <td style='border: solid 2px'>
                    <input style='width: 95%' type='text' name='update_product_status' value='$status_dostepnosci'/>
                    </td>
                    <td style='border: solid 2px'>
                    <input style='width: 95%' type='text' name='update_product_category' value='$kategoria'/>
                    </td>
                    <td style='border: solid 2px'>
                    <input style='width: 95%' type='number' name='update_product_gabaryt' value='$gabaryt'/>
                    </td>
                    <td style='border: solid 2px'>
                    <img style='width: 75px; height: 75px' src='data:image/jpeg;base64, $zdjecie'/>
                    <input type='hidden' name='defaultphoto' value='$zdjecie'>
                    <input type='file' name='updateproductphoto' value='$zdjecie'/>
                    </td>
                    </tr>                     
                </tbody>
                </table>
            <button type='submit'>Zapisz</button>
            </form>
        </div>
        </div>
        <br>
        ";
        return $edit_product_form;
    }
    return "Wystąpił błąd podczas edycji produktu {$product_id}";
}

include("cfg.php");

	echo "<center>
		<h1>Sklep</h1><br>
		<a href='admin/admin.php'><h2 style='color: red'>Panel administracyjny CMS</h2></a>
		<a href='index.php'><h2 style='color: red'>Strona główna</h2></a></div></center></div></center>";
	
	echo "<button onclick=location.href='categories_management.php' type='button'> Cofnij</button>";
	
	echo "<button onclick=location.href='cart_content.php' type='button' class='topright'> Koszyk</button>";
	
	

	

if($_SESSION['loginFailed'] == 0) {
    echo "<form method='post'>
    <input type='submit' name='add_new' id='add_new' value='dodaj kategorie' /><br/>
    </form>";


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['category_id'])) {
            edit_category_form();
        }

        if(array_key_exists('new_product',$_POST)){
            echo new_product_form();
        }

        if(array_key_exists('add_new',$_POST)){
            echo add_category_form();
        }

        if(array_key_exists('update_product', $_POST)) {
            echo edit_product_form();
        }

        include_once("categories_functions.php");
        include_once("product_functions.php");
        include_once("cart_functions.php");

         if(isset($_POST['new_category_parent']) || isset($_POST['new_category_name'])) {
            $message = handle_add_category();
        }

        if(isset($_POST['category_to_delete_id'])) {
            $message = handle_delete_category();
        }

        if(isset($_POST['edit_id'])) {
            $message = handle_edit_category();
        }

        if(isset($_POST['new_product_category'])) {
            $message = handle_add_product();
        }

        if(isset($_POST['product_to_delete_id'])) {
            $message = handle_delete_product();
        }

        if(isset($_POST['update_product_id'])) {
            $message = handle_edit_product();
        }


        if(isset($_POST['add_to_cart_id'])) {
            $message = addToCart();
        }

     }

    list_categories();
} else {
    echo "Nie zalogowano się!";
}