<?php
include "../db.php";

$id = intval($_GET['id']);
$status = $_GET['status'];

mysqli_query($conn, "
UPDATE commande
SET status='$status'
WHERE id=$id
");

header("Location: client_commande.php?email=" . urlencode($_GET['email']));
exit;
?>