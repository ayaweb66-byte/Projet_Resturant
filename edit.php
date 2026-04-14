<?php
include "../db.php";

if (!isset($_GET['id'])) {
    die("ID missing");
}

$id = intval($_GET['id']);

$result = mysqli_query($conn, "SELECT * FROM plat WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Plat not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $categorie_id = $_POST['categorie_id'];

    $sql = "UPDATE plat 
            SET nom='$nom', prix='$prix', categorie_id='$categorie_id'
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('✅ Plat modifié');
        window.location.href='get.php';
        </script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
if (mysqli_query($conn, $sql)) {
    header("Location: get.php");
    exit;
}
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit plat</title>
    <link rel="stylesheet" href="style-edit.css">
</head>
<body>

<h2>Modifier plat</h2>

<form method="POST">

    <input type="text" name="nom" value="<?= $data['nom'] ?>"><br><br>

    <input type="number" name="prix" value="<?= $data['prix'] ?>"><br><br>

    <select name="categorie_id">
        <option value="1" <?= $data['categorie_id']==1?'selected':'' ?>>Entrées</option>
        <option value="2" <?= $data['categorie_id']==2?'selected':'' ?>>Plats principaux</option>
        <option value="3" <?= $data['categorie_id']==3?'selected':'' ?>>Desserts</option>
        <option value="4" <?= $data['categorie_id']==4?'selected':'' ?>>Boissons</option>
    </select>

    <br><br>

    <button type="submit">Modifier</button>

</form>

</body>
</html>
