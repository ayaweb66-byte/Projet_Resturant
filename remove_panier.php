<?php
session_start();

// تأكد من وجود id
if (isset($_GET['id'])) {

    $id = (int) $_GET['id'];

    if (isset($_SESSION['panier'][$id])) {
        unset($_SESSION['panier'][$id]);
    }
}

// رجوع للصفحة
header("Location: add.php");
exit;
?>