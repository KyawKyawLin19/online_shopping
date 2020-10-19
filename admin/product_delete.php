<?php

    require_once('../config/config.php');

    $stmt = $pdo->prepare("DELETE FROM products WHERE id=".$_GET['id']);

    $stmt->execute();

    header('Location: product_list.php');

?>