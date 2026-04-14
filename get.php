<?php
include "../db.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "SELECT id, nom 
        FROM categorie 
        WHERE id IN (
            SELECT MAX(id) 
            FROM categorie 
            GROUP BY nom
        )
       ";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Liste des catégories</title>

<style>
body{
    font-family: Arial;
    background:#f4f6f9;
}

table{
    width:70%;
    margin:30px auto;
    border-collapse:collapse;
    background:white;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    text-align:center;
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

a.delete{
    color:white;
    background:#d63031;
    padding:6px 12px;
    text-decoration:none;
    border-radius:6px;
}

a.delete:hover{
    background:#b71c1c;
}

h2{
    text-align:center;
}
</style>

</head>

<body>

<h2>📂 Liste des catégories</h2>

<table>
<tr>
    <th>ID</th>
    <th>Nom</th>
    <th>Action</th>
</tr>

<?php if(mysqli_num_rows($result) > 0){ ?>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>

    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['nom'] ?></td>
        <td>
            <a class="delete"
               href="delete.php?id=<?= $row['id'] ?>"
               onclick="return confirm('Supprimer cette catégorie ?')">
               ❌ Supprimer
            </a>
        </td>
    </tr>

    <?php } ?>

<?php } else { ?>

<tr>
    <td colspan="3">Aucune catégorie trouvée</td>
</tr>

<?php } ?>

</table>

</body>
</html>