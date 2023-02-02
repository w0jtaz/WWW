<?php
echo "<body style='background-color: c0c0c0;'>"; 
include("cart_functions.php");

echo "<button onclick=location.href='categories_management.php' type='button'>
    Sklep
    </button><br><br>";

if($_SESSION['loginFailed'] == 0) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['cart_product_delete_id'])) {
            $message = removeFromCart();
            $_SESSION['message'] = $message;
      
            exit;
        }
    }

    echo showCartContent();

}
