<?php
session_start();
include "../db.php";

if (!isset($_SESSION['client_id'])) {
    $_SESSION['client_id'] = 1; // demo
}

/* =========================
   ADD TO PANIER (EXAMPLE)
========================= */
if (isset($_GET['add'])) {

    $id = intval($_GET['add']);

    if (!isset($_SESSION['panier'][$id])) {
        $_SESSION['panier'][$id] = 1;
    } else {
        $_SESSION['panier'][$id]++;
    }

    header("Location: add.php");
    exit;
}

/* =========================
   VALIDATE COMMANDE
========================= */
if (isset($_POST['valider'])) {

    if (empty($_SESSION['panier'])) {
        die("<script>alert('Panier vide');window.location='add.php';</script>");
    }

    $client_id = intval($_SESSION['client_id']);

    /* 1. CREATE COMMANDE */
    $sql = "INSERT INTO commande (client_id) VALUES ($client_id)";
    mysqli_query($conn, $sql);

    $commande_id = mysqli_insert_id($conn);

    if (!$commande_id) {
        die("Erreur commande_id");
    }

    /* 2. INSERT ITEMS */
    foreach ($_SESSION['panier'] as $id => $qte) {

        $id = intval($id);
        $qte = intval($qte);

        $sql2 = "INSERT INTO ligne_commande (commande_id, plat_id, quantite)
                 VALUES ($commande_id, $id, $qte)";

        mysqli_query($conn, $sql2);
    }

    /* 3. SAVE LAST ORDER */
    $_SESSION['last_commande_id'] = $commande_id;

    /* 4. CLEAR PANIER */
    unset($_SESSION['panier']);

    echo "<script>
        alert('Commande enregistrée');
        window.location='add.php';
    </script>";
    exit;
}

/* =========================
   GET PLATS
========================= */
$sql = "SELECT * FROM plat";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Panier</title>
<style>
body {font-family:Arial;background:#f4f6f8;}
table {width:70%;margin:auto;background:white;border-collapse:collapse;}
th,td {border:1px solid #ddd;padding:10px;text-align:center;}
th {background:#2d3436;color:white;}
button {padding:10px;background:#6c5ce7;color:white;border:none;}
</style>
</head>
<body>

<h2 style="text-align:center;">🍽 Plats</h2>

<table>
<tr>
    <th>Nom</th>
    <th>Prix</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?= $row['nom'] ?></td>
    <td><?= $row['prix'] ?> DH</td>
    <td>
        <a href="?add=<?= $row['id'] ?>">➕ Ajouter</a>
    </td>
</tr>
<?php } ?>

</table>

<!-- PANIER -->
<h2 style="text-align:center;">🛒 Panier</h2>

<div style="width:60%;margin:auto;background:white;padding:10px;">

<?php
if (!empty($_SESSION['panier'])) {

    $total = 0;

    foreach ($_SESSION['panier'] as $id => $qte) {

        $res = mysqli_query($conn, "SELECT nom, prix FROM plat WHERE id=$id");
        $p = mysqli_fetch_assoc($res);

        $sub = $p['prix'] * $qte;
        $total += $sub;

        echo "<div>{$p['nom']} x $qte = $sub DH</div>";
    }

    echo "<h3>Total: $total DH</h3>";

} else {
    echo "Panier vide";
}
?>

</div>

<form method="POST" style="text-align:center;">
    <button name="valider">✅ Valider commande</button>
</form>

<!-- FIX LINK -->
<div style="text-align:center;margin-top:20px;">
<?php if (isset($_SESSION['last_commande_id'])): ?>

<style>
    .btn-commande {
        display: inline-block;
        padding: 12px 20px;
        background: linear-gradient(135deg, #0984e3, #6c5ce7);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: bold;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        transition: 0.3s ease;
    }

    .btn-commande:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        background: linear-gradient(135deg, #6c5ce7, #0984e3);
    }

    .btn-container {
        text-align: center;
        margin-top: 20px;
    }
</style>

<div class="btn-container">
    <a class="btn-commande" href="details_commande.php?id=<?= $_SESSION['last_commande_id'] ?>">
        📦 Voir ma commande
    </a>
</div>

<?php endif; ?>
</div>

</body>
</html>