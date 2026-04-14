<?php
include "../db.php";

/* =========================
   GET DISTINCT CLIENTS
========================= */
$sql = "
SELECT DISTINCT 
    client.email,
    client.nom,
    client.id
FROM client
JOIN commande ON commande.client_id = client.id
ORDER BY client.id DESC
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Clients</title>

<style>
body{
    font-family: Arial;
    background:#f4f6f9;
}

/* TABLE */
table{
    width:80%;
    margin:20px auto;
    text-align:center;
    border-collapse:collapse;
    background:white;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

th{
    background:#2d3436;
    color:white;
    padding:12px;
}

td{
    padding:10px;
    border-bottom:1px solid #ddd;
}

tr:hover{
    background:#f1f1f1;
}

/* BUTTONS */
.btn-container{
    width:80%;
    margin:20px auto;
    display:flex;
    justify-content:center;
    gap:20px;
}

.btn{
    padding:12px 20px;
    text-decoration:none;
    color:white;
    border-radius:8px;
    font-weight:bold;
    transition:0.3s;
}

.add{
    background:#00b894;
}

.add:hover{
    background:#019875;
}

.delete{
    background:#d63031;
}

.delete:hover{
    background:#b71c1c;
}

h2{
    text-align:center;
}
</style>

</head>

<body>

<h2>📊 Admin - Clients</h2>

<table>
<tr>
    <th>Client</th>
    <th>Email</th>
    <th>Voir commandes</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>
    <td><?= $row['nom'] ?></td>
    <td><?= $row['email'] ?></td>

    <td>
        <a href="client_commande.php?email=<?= urlencode($row['email']) ?>">
            👁 Voir commandes
        </a>
    </td>
</tr>

<?php } ?>

</table>

<!-- ✅ BUTTONS -->
<div class="btn-container">
    <a href="../categorie/add.php" class="btn add">➕ Ajouter Catégorie</a>
    <a href="../categorie/delete.php" class="btn delete">
       ❌ Supprimer Catégorie
    </a>
</div>

</body>
</html>