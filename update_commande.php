<?php
include "../db.php";

// 🔐 Vérification des paramètres
if (!isset($_GET['id']) || !isset($_GET['status'])) {
    die("Données manquantes");
}

$id = intval($_GET['id']);
$status = $_GET['status'];

// 🔒 Validation status
$allowed = ['validee', 'refusee'];
if (!in_array($status, $allowed)) {
    die("Status invalide");
}

/* =====================================
   1. GET CLIENT INFO
===================================== */
$sqlClient = "
    SELECT client.nom, client.email
    FROM commande
    JOIN client ON commande.client_id = client.id
    WHERE commande.id = $id
";

$resClient = mysqli_query($conn, $sqlClient);

if (!$resClient || mysqli_num_rows($resClient) == 0) {
    die("Client introuvable");
}

$client = mysqli_fetch_assoc($resClient);
$email = $client['email'];
$nom = $client['nom'];

/* =====================================
   2. UPDATE COMMANDE STATUS
===================================== */
$update = "UPDATE commande SET status='$status' WHERE id=$id";

if (!mysqli_query($conn, $update)) {
    die("Erreur update: " . mysqli_error($conn));
}

/* =====================================
   3. SEND EMAIL IF VALIDATED
===================================== */
if ($status == "validee") {

    $subject = "Confirmation de votre commande #$id";

    $message = "
    Bonjour $nom,

    Votre commande #$id a été VALIDÉE ✅

    🚚 Elle sera préparée et livrée prochainement à votre adresse.

    Merci pour votre confiance 🙏
    ";

    // 📧 Headers email
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "From: no-reply@votre-site.com\r\n";

    mail($email, $subject, $message, $headers);
}

/* =====================================
   4. REDIRECT BACK
===================================== */
header("Location: details_commande.php?id=$id");
exit;
?>