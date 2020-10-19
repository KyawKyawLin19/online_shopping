<?php

session_start();

require_once('config/config.php');
require_once('config/common.php');

if($_POST) {

    $id = $_POST['id'];
    $qty = $_POST['qty'];

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$id);

    $stmt->execute();

    $product = $stmt->fetch(PDO::FETCH_OBJ);

    if($qty > $product->quantity) {
        echo "<script>alert('not enough stock');window.location.href='product_detail.php?id=$id'</script>";
    }else {

        if(isset($_SESSION['cart']['id'.$id])) {
            if($_SESSION['cart']['id'.$id]+$qty > $product->quantity) {
                echo "<script>alert('not enough stock in');window.location.href='product_detail.php?id=$id'</script>";
                exit(); 
            } else {
                $_SESSION['cart']['id'.$id] += $qty;
            }
        }else {
            $_SESSION['cart']['id'.$id] = $qty;
        }

        header("Location: cart.php");        

    }
    
}


?>