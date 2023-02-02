<?php
@session_start();

function updateItemQuantity($id, $item_stock) {
    include("cfg.php");

    $query="UPDATE `product` SET `dostepna_ilosc` = $item_stock WHERE `id` = $id ";
    $result=mysqli_query($link, $query);
    if($result) {
        return true;
    } else {
        return false;
    }
}

function addToCart() {

    if (!isset($_SESSION['items_count'])) {
        $_SESSION['items_count'] = 1;
    } else {
        $_SESSION['items_count'] ++;
    }
    $item_no = $_SESSION['items_count'];

    $item_id = $_POST['add_to_cart_id'];
    $item_stock = $_POST['add_to_cart_quantity_left'] - 1;

    $update = updateItemQuantity($item_id, $item_stock);

    if (!$update) {
        return "Błąd przy dodawaniu do koszyka!";
    }

    $exists = false;
    for ($i = 1; $i <= $item_no; $i++) {
        if($_SESSION['cart'][$i]["id"]==$item_id){
            $_SESSION['cart'][$i]["quantity"] ++;
            $exists = true;
            break;
        }
    }
    if(!$exists) {
        $_SESSION['cart'][$item_no] = array('id' => $item_id, 'quantity' => 1);
    }

    echo  "Dodano do koszyka!";
}

function removeFromCart() {


    $current_id = $_POST['cart_product_delete_id'];
    $products = $_SESSION['cart'];

    $delete = null;

    foreach ($products as $product) {
        if ($product['id'] == $current_id) {
            $delete = $product;
        }
    }

    if ($delete == null) {
        echo "Błąd przy usuwaniu z koszyka!";
    }

    $item_no = array_search($delete, $products);

    $new_quantity = $_POST['cart_product_delete_quantity']+1;
    $current_id = $_SESSION['cart'][$item_no]["id"];

    if(!updateItemQuantity($current_id, $new_quantity)) {
		echo "Błąd przy usuwaniu z koszyka!";
    }

    $_SESSION['cart'][$item_no]['quantity']--;
    $_SESSION['items_count']--;


    if ($_SESSION['cart'][$item_no]['quantity'] == 0) {
        unset( $_SESSION['cart'][$item_no]);
    }

    echo "Usunięto produkt z koszyka!";
}

function showCartContent() {
    $item_count = @$_SESSION['items_count'];
    $cena_all = 0;
    $site_result = "";
    $site_result .= "<div >
        <div>
            <table style='background-color: white'>
                <thead>                   
                   
                    <th style='border: solid 2px'><span>zdjecie</span></th>
                    <th style='border: solid 2px'><span>cena brutto za sztuke</span></th>
                    <th style='border: solid 2px'><span>ilosc</span></th>
                    <th style='border: solid 2px'><span>akcje</span></th>
                </thead>";

    if($item_count == 0) {
        return "Koszyk jest pusty, dodaj jakiś produkt w sklepie!";
    }

    $products = $_SESSION['cart'];

    foreach ($products as $product) {
        $current_id = $product["id"];
        $quantity_in_cart = $product["quantity"];

        include("cfg.php");


        $query="SELECT * FROM `product` WHERE id = $current_id LIMIT 1";
        $result=mysqli_query($link, $query);

        while($row = mysqli_fetch_array($result)) {
            $zdjecie = base64_encode($row['zdjecie']);
            $cena_netto = $row['cena_netto'];
            $vat = $row['podatek_vat'];
            $ilosc = $row['dostepna_ilosc'];
            $brutto = round($cena_netto + $cena_netto * ($vat/100), 2);
            $zdjecie = base64_encode($row['zdjecie']);

            $cena_all += $brutto * $quantity_in_cart;

            $site_result .=  "        
                <tbody style='background-color: white; border: solid 2px'>
                    <tr> 
                    <td style='border: solid 2px'><img style='width: 75px; height: 75px' src='data:image/jpeg;base64, $zdjecie'/></td>
                    <td style='border: solid 2px'>$brutto zł</td>
                    <td style='border: solid 2px'>$quantity_in_cart</td>
                    <td style='border: solid 2px'>
                    <form method='post'>
                        <input type='hidden' name='cart_product_delete_id' value='". $current_id ."'/>
                        <input type='hidden' name='cart_product_delete_quantity' value='".$ilosc."'/>
                        <input type='submit' name='delete' value='Usun z koszyka'/>
                    </form>
                    </td>
                    </tr>       
                </tbody>
            
        ";
        }
    }

    $site_result .= "</table>
            
        </div>
        
        </div>
        
        <h3>Cena: $cena_all ZŁ</h3>
        ";

    return $site_result;
}

