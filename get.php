<?php
include "../db.php";

$sql = "SELECT plat.*, categorie.nom AS categorie_nom
        FROM plat
        LEFT JOIN categorie ON plat.categorie_id = categorie.id";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des plats</title>
    <link rel="stylesheet" href="style2.css">

    <style>
        .top-actions {
            text-align:center;
            margin:20px;
        }

        .btn {
            padding:8px 12px;
            text-decoration:none;
            border-radius:5px;
            margin:5px;
            display:inline-block;
        }

        .add {
            background:green;
            color:white;
        }

        .orders {
            background:#0984e3;
            color:white;
        }
    </style>
</head>

<body>

<h2 style="text-align:center;">🍽 Liste des plats</h2>

<!-- ACTION BUTTONS -->
<div class="top-actions">

    <a class="btn add" href="add.php">➕ Ajouter un plat</a>

    <!-- FIXED LINK -->
    <a class="btn orders" href="../commande/get.php">
        📦 Voir les commandes reçues
    </a>

</div>

<table>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prix</th>
        <th>Catégorie</th>
        <th>Actions</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['nom'] ?></td>
        <td><?= $row['prix'] ?> DH</td>
        <td><?= $row['categorie_nom'] ?></td>
        <td>
            <a class="btn edit" href="edit.php?id=<?= $row['id'] ?>">✏️ Edit</a>
            <a class="btn delete" href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Supprimer ce plat ?')">❌ Delete</a>
        </td>
    </tr>
    <?php } ?>

</table>

</body>
</html>