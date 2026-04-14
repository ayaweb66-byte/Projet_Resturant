<?php
include "../db.php";

if (!isset($_GET['id'])) {
    die("ID manquant");
}

$id = intval($_GET['id']);

/* =========================
   DELETE ORDER (NEW)
========================= */
if (isset($_POST['delete_order'])) {
    $delete_id = intval($_POST['order_id']);

    // حذف items أولاً
    mysqli_query($conn, "DELETE FROM ligne_commande WHERE commande_id = $delete_id");

    // حذف commande
    mysqli_query($conn, "DELETE FROM commande WHERE id = $delete_id");

}

/* CLIENT */
$sqlClient = "
SELECT client.email, client.nom
FROM commande
JOIN client ON client.id = commande.client_id
WHERE commande.id = $id
LIMIT 1
";

$resClient = mysqli_query($conn, $sqlClient);
$client = mysqli_fetch_assoc($resClient);
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<!-- AUTO REFRESH -->
<meta http-equiv="refresh" content="3">

<title>Commande Details</title>

</head>

<body>

<h2 style="text-align:center;">
📦 Commandes de <?= htmlspecialchars($client['nom']) ?>
</h2>

<h4 style="text-align:center;">
📧 <?= htmlspecialchars($client['email']) ?>
</h4>

<?php
$sqlOrders = "
SELECT id, status, date_commande
FROM commande
WHERE client_id = (
    SELECT client_id FROM commande WHERE id=$id
)
ORDER BY date_commande DESC
";

$resultOrders = mysqli_query($conn, $sqlOrders);

while ($order = mysqli_fetch_assoc($resultOrders)) {
    $order_id = $order['id'];
?>

<div style="margin-top:30px;">

    <h3 style="text-align:center;">
        📅 Commande #<?= $order_id ?> - <?= $order['date_commande'] ?>
    </h3>

    <!-- STATUS -->
    <div style="text-align:center;margin-bottom:10px;">

        <?php if ($order['status'] == "accepter"): ?>
            <span style="background:green;color:white;padding:6px 12px;">✔ Acceptée</span>

        <?php elseif ($order['status'] == "refuser"): ?>
            <span style="background:red;color:white;padding:6px 12px;">✖ Refusée</span>

        <?php else: ?>
            <span style="background:orange;color:black;padding:6px 12px;">⏳ En attente</span>
        <?php endif; ?>

    </div>

    <!-- DELETE BUTTON -->
    <form method="POST" style="text-align:center;margin-bottom:10px;">
        <input type="hidden" name="order_id" value="<?= $order_id ?>">
        <button type="submit" name="delete_order"
            onclick="return confirm('متأكد بغيتي تمسح هاد commande؟')"
            style="background:red;color:white;padding:6px 12px;border:none;cursor:pointer;">
            🗑 Supprimer commande
        </button>
    </form>

    <!-- ITEMS -->
    <table border="1" style="width:80%;margin:auto;text-align:center;">
        <tr style="background:#2d3436;color:white;">
            <th>Plat</th>
            <th>Prix</th>
            <th>Quantité</th>
            <th>Total</th>
        </tr>

        <?php
        $items = mysqli_query($conn, "
            SELECT plat.nom, plat.prix, ligne_commande.quantite,
            (plat.prix * ligne_commande.quantite) AS total
            FROM ligne_commande
            JOIN plat ON plat.id = ligne_commande.plat_id
            WHERE ligne_commande.commande_id = $order_id
        ");

        $total = 0;

        while ($row = mysqli_fetch_assoc($items)) {
            $total += $row['total'];
        ?>

        <tr>
            <td><?= htmlspecialchars($row['nom']) ?></td>
            <td><?= $row['prix'] ?> DH</td>
            <td><?= $row['quantite'] ?></td>
            <td><?= $row['total'] ?> DH</td>
        </tr>

        <?php } ?>

        <tr style="background:#f1f1f1;font-weight:bold;">
            <td colspan="3">💰 Total</td>
            <td><?= $total ?> DH</td>
        </tr>

    </table>

</div>

<?php } ?>

</body>
</html>