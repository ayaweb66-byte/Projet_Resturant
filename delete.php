<?php
include "../db.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM plat WHERE id = $id";
    mysqli_query($conn, $sql);

    header("Location: get.php");
    exit();
}
?>