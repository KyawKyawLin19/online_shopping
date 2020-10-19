<?php

    require_once('../config/config.php');

    $stmt=$pdo->prepare("DELETE FROM categories WHERE id=".$_GET['id']);

    $stmt->execute();
 
    header('Location: index.php');
?>