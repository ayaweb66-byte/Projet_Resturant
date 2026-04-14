<?php
session_start();

// check id
if (isset($_GET['id'])) {

    $id = (int) $_GET['id']; // sécurité

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    if (isset($_SESSION['panier'][$id])) {
        $_SESSION['panier'][$id]++;
    } else {
        $_SESSION['panier'][$id] = 1;
    }
}

// redirect (بدل add.php حسب المشروع ديالك)
header("Location: add.php");
exit;
?>