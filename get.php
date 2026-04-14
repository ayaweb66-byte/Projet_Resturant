


<?php
session_start();
include "../db.php";

$sql = "SELECT 
            commande.id AS commande_id,
            commande.date_commande,
            client.nom AS client_nom,
            client.email
        FROM commande
        JOIN client ON commande.client_id = client.id
        ORDER BY commande.date_commande DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Commandes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>🧾 Liste des commandes</h2>


<table border="1" width="80%" align="center">
<tr>
    <th>ID Commande</th>
    <th>Client</th>
    <th>Email</th>
    <th>Date</th>
    <th>Détails</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?= $row['commande_id'] ?></td>
    <td><?= $row['client_nom'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= $row['date_commande'] ?></td>
    <td>
        
<a href="../commande/details_commande.php?id=<?= $row['commande_id'] ?>">
    👁 Voir
</a>

    </td>
</tr>
<?php } ?>

</table>

</body>
</html>