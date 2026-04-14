<?php
include "../db.php";

if (!isset($_GET['email'])) {
    die("Email manquant");
}

$email = $_GET['email'];

/* GET CLIENT */
$resClient = mysqli_query($conn, "SELECT * FROM client WHERE email='$email'");
$client = mysqli_fetch_assoc($resClient);

/* GET COMMANDES */
$sql = "
SELECT * FROM commande
WHERE client_id = {$client['id']}
ORDER BY date_commande DESC
";

$result = mysqli_query($conn, $sql);
?>

<h2 style="text-align:center;">
📦 Commandes de <?= $client['nom'] ?> (<?= $client['email'] ?>)
</h2>

<?php while($order = mysqli_fetch_assoc($result)) { ?>

<div style="width:85%;margin:20px auto;padding:15px;border:1px solid #ddd;border-radius:10px;">

    <!-- HEADER -->
    <h3>🧾 Commande #<?= $order['id'] ?> | <?= $order['date_commande'] ?></h3>

    <!-- STATUS -->
    <p>
        <?php if ($order['status'] == "accepter"): ?>
            <span style="color:green;font-weight:bold;">✔ Accepter</span>
        <?php elseif ($order['status'] == "refuser"): ?>
            <span style="color:red;font-weight:bold;">✖ Refuser</span>
        <?php else: ?>
            <span style="color:orange;font-weight:bold;">⏳ En attente</span>
        <?php endif; ?>
    </p>

    <!-- ACTION BUTTONS -->
    <div style="margin-bottom:10px;">
        <a href="update_status.php?id=<?= $order['id'] ?>&status=accepter&email=<?= urlencode($email) ?>"
           style="color:green;font-weight:bold;">
           ✔ Accepter
        </a>

        |

        <a href="update_status.php?id=<?= $order['id'] ?>&status=refuser&email=<?= urlencode($email) ?>"
           style="color:red;font-weight:bold;">
           ✖ Refuser
        </a>

        |

        <a href="update_status.php?id=<?= $order['id'] ?>&status=en_attente&email=<?= urlencode($email) ?>"
           style="color:orange;font-weight:bold;">
           ⏳ Reset
        </a>
    </div>

    <!-- ITEMS -->
    <table border="1" style="width:100%;text-align:center;">
        <tr style="background:#2d3436;color:white;">
            <th>Plat</th>
            <th>Prix</th>
            <th>Quantité</th>
            <th>Total</th>
        </tr>

        <?php
        $order_id = $order['id'];

        $sqlItems = "
        SELECT 
            plat.nom,
            plat.prix,
            ligne_commande.quantite,
            (plat.prix * ligne_commande.quantite) AS total
        FROM ligne_commande
        JOIN plat ON plat.id = ligne_commande.plat_id
        WHERE ligne_commande.commande_id = $order_id
        ";

        $items = mysqli_query($conn, $sqlItems);

        $total = 0;

        while ($row = mysqli_fetch_assoc($items)) {
            $total += $row['total'];
        ?>

        <tr>
            <td><?= $row['nom'] ?></td>
            <td><?= $row['prix'] ?> DH</td>
            <td><?= $row['quantite'] ?></td>
            <td><?= $row['total'] ?> DH</td>
        </tr>

        <?php } ?>

        <tr style="font-weight:bold;background:#f1f1f1;">
            <td colspan="3">💰 Total</td>
            <td><?= $total ?> DH</td>
        </tr>

    </table>

</div>

<?php } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta http-equiv="refresh" content="5">
</head>
<body>
    
</body>
</html>